<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{

    /**
     * Handle customer login and return a token if successful.
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;

                $user->photo = env('APP_URL') . '/customers/' . $user->photo;

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => $user
                ]);
            } else {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    /**
     * Check if the user is authenticated.
     */
    public function checkAuth(Request $request)
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                return response()->json([
                    'authenticated' => true,
                    'user' => $user
                ]);
            } else {
                return response()->json([
                    'authenticated' => false,
                    'message' => 'User is not authenticated'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    /**
     * Handle forgot password and send a reset token to the user email.
     */
    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $customer = Customer::where('email', $request->email)->first();

            if (!$customer) {
                return response()->json([
                    'message' => 'Email not found'
                ], 404);
            }

            $token = substr(str_shuffle("0123456789"), 0, 4);

            // dd($token);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]
            );

            // Mail::to($request->email)->send(new PasswordResetMail($token));

            Mail::send('mails.send-forgot-password-mail-otp', [
                'token' => $token,
            ], function ($messages) use ($request) {
                $messages->to($request->email);
                $messages->subject('Reset Password OTP');
            });

            return response()->json([
                'message' => 'Reset password token sent on your email id.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    /**
     * Verify the OTP for the customer.
     */
    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'token' => 'required|numeric|digits:4'
            ]);

            $customer = DB::table('password_reset_tokens')->where('email', $request->email)->first();

            if (!$customer) {
                return response()->json([
                    'message' => 'Email not found'
                ], 404);
            }

            if ($customer->token != $request->token) {
                return response()->json([
                    'message' => 'Invalid OTP'
                ], 401);
            }

            return response()->json([
                'message' => 'OTP verified successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset the password of the customer.
     */
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|confirmed|min:8',
                'password_confirmation' => 'required',
                'token' => 'required|numeric|digits:4'
            ]);

            $updatePassword = DB::table('password_reset_tokens')
                ->where([
                    'email' => $request->email,
                    'token' => $request->token,
                ])
                ->first();

            if (!$updatePassword) {
                return response()->json([
                    'message' => 'Invalid token or email'
                ], 401);
            }

            $customer = Customer::where('email', $request->email)->first();
            $customer->password = $request->password;
            $customer->save();

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return response()->json([
                'message' => 'Password reset successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $customers = Customer::all();
            return response()->json([
                'message' => 'List of all customers',
                'data' => $customers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check availability of customer signup.
     */
    public function checkSignup(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $customer = Customer::where('email', $request->email)->first();

            return response()->json([
                'message' => 'Availability checked successfully',
                'available' => !$customer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle customer signup and store a newly created customer in storage.
     */
    public function store(StoreCustomerRequest $request)
    {

        // dd($request->all());
        $validatedData = $request->validated();

        try {
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('customers', $fileName, 'public');
            
                $validatedData['photo'] = $fileName;
            }         

            $customer = Customer::create($validatedData);
            
            return response()->json([
                'message' => 'Customer signed up successfully',
                'customer' => $customer
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $customer = Customer::findOrFail($id);
            
            return response()->json([
                'message' => 'Customer details',
                'customer' => $customer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    /**
     * Handle unauthenticated requests.
     */
    public function unauthenticated()
    {
        return response()->json([
            'message' => 'User is not authenticated'
        ], 401);
    }
}
