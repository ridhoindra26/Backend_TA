<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $id = auth()->id();
            $transactions = Transaction::where('customer_id', $id)->get();
            return response()->json([
                'message' => 'List of all Transaction',
                'data' => $transactions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        $reference_id = 'order-id-' . time();
        $expires_at = now()->addHour()->toISOString();
        $callback_url = config('services.xendit.webhook_url', 'https://mobiledrone.l-prepaid.com/api/order/webhook');
        $key = env('XENDIT_SECRET_KEY');

        try {
            
            $transaction = Transaction::create([
                'customer_id' => auth()->id(),
                'station_id' => $request->station_id,
                'status' => 'Pending',
                'payment_method' => $request->payment_method,
                'total_price' => $request->total_price,
                'xendit_id' => null,
                'reference_id' => $reference_id,
                'qr_string' => null
            ]);
            
            $response = Http::withBasicAuth('xnd_production_g6FoUeY8qm7w3vGTp4YBwfw4UmakiliS43uwt2tt4Gub9Yg8jqLyU3OrYONe5', '')
                ->post('https://api.xendit.co/qr_codes', [
                    'reference_id' => $reference_id,
                    'type' => 'DYNAMIC',
                    'currency' => 'IDR',
                    'amount' => 10,
                    'expires_at' => $expires_at,
                    'external_id' => (string) $transaction->id,
                    'callback_url' => $callback_url,
                ]);
            
            if (!$response->successful()) {
                Log::error('Xendit API Error:', $response->json());

                return response()->json([
                    'message' => 'Failed to create QR code',
                    'error' => $response->json(),
                ], 500);
            }

            $xenditData = $response->json();

            $transaction->update([
                'xendit_id' => $xenditData['id'],
                'qr_string' => $xenditData['qr_string']
            ]);

            foreach ($request->products as $prod) {
                $transaction->detailTransactions()->create([
                    'product_id' => $prod['id'],
                    'quantity' => $prod['quantity'],
                    'price' => $prod['price'],
                ]);
            }

            return response()->json([
                'message' => 'Transaction created successfully',
                'data' => [
                    'transaction' => $transaction,
                    'xendit' => $xenditData
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Transaction Store Error:', ['error' => $e->getMessage()]);

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
            $authId = auth()->id();
            $transaction = Transaction::where('customer_id', $authId)
                ->with('detailTransactions.product')
                ->findOrFail($id);
            return response()->json([
                'message' => 'Transaction details',
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Webhook for Xendit notifications.
     */
    public function webhook(Request $request)
    {
        // Simpan log request untuk debugging
        Log::info('Xendit Webhook Received:', $request->all());

        // Verifikasi header X-CALLBACK-TOKEN jika digunakan
        $expectedToken = env('XENDIT_WEBHOOK_TOKEN');
        $receivedToken = $request->header('X-CALLBACK-TOKEN');

        if ($expectedToken && $receivedToken !== $expectedToken) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Validasi payload
        $validator = Validator::make($request->all(), [
            'qr_code.id' => 'required|string',
            'qr_code.external_id' => 'required|string',
            'amount' => 'required|numeric',
            'status' => 'required|string',
            'payment_details.source' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid payload', 'errors' => $validator->errors()], 400);
        }

        // Cek apakah transaksi dengan external_id sudah ada
        $transaction = Transaction::where('id', $request->external_id)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Update transaksi
        $transaction->update([
            'xendit_id' => $request->id,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Webhook processed successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
