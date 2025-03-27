<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

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
        // $validatedData = $request->validated();
        try {
            $transaction = Transaction::create([
                'customer_id' => auth()->id(),
                'station_id' => $request->station_id,
                'status' => 'Pending',
                'payment_method' => $request->payment_method,
                'total_price' => $request->total_price,
            ]);

            $data = $request->products;
            foreach($data as $prod) {
                $transaction->detailTransactions()->create([
                    'product_id' => $prod['id'],
                    'quantity' => $prod['quantity'],
                    'price' => $prod['price'],
                ]);
            }
            return response()->json([
                'message' => 'Order has been created',
                'data' => $transaction
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
            $authId = auth()->id();
            $transaction = Transaction::where('customer_id', $authId)->findOrFail($id);
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
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
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
