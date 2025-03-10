<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Requests\UpdateWishlistRequest;

class WishlistController extends Controller
{
    /**
     * Display a listing of all wishlists.
     */
    public function index()
    {
        try {
            $wishlists = Wishlist::all();
            return response()->json([
                'message' => 'List of all wishlists',
                'data' => $wishlists
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
    public function store(StoreWishlistRequest $request)
    {
        $validatedData = $request->validated();
        
        $customerId = auth()->id(); 

        $validatedData['customer_id'] = $customerId;

        try {
            $wishlist = Wishlist::create($validatedData);
            return response()->json([
                'message' => 'Wishlist created successfully',
                'wishlist' => $wishlist
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
            $wishlist = Wishlist::where('customer_id', $id)->get();
            return response()->json([
                'message' => 'Wishlist Customer List',
                'wishlist' => $wishlist
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
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWishlistRequest $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customerId = auth()->id();

        $wishlist = Wishlist::where('customer_id', $customerId)
                            ->where('product_id', $id)
                            ->first();

        if (!$wishlist) {
            return response()->json([
                'message' => 'Wishlist item not found'
            ], 404);
        }

        try {
            $wishlist->delete();
            return response()->json([
                'message' => 'Wishlist item deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
