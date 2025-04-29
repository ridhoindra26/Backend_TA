<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Category;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::where('status',1)->get();
            return response()->json([
                'message' => 'List of all products',
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a list of featured products for the home page.
     */

    public function home()
    {
        try {
            $topProducts = Product::withCount('detailTransactions')
                            ->where('status',1)
                            ->orderBy('detail_transactions_count', 'desc')
                            ->take(5)
                            ->get();
                                    
            return response()->json([
                'message' => 'Top 5 products based on the most transactions',
                'data' => $topProducts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of products by category.
     */
    public function categoryList()
    {
        try {
            $categories = Category::all();
            
            return response()->json([
                'message' => 'List of category',
                'data' => $categories
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
        // return response()->json('$data', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        try {
            $user_id = auth()->id();

            $product = Product::with('variants.variantCategory.variants')->findOrFail($id);
            $wishlistCount = Wishlist::where('product_id', $id)->count();
            $hasWishlist = Wishlist::where('customer_id', $user_id)
                                    ->where('product_id', $id)
                                    ->exists();
            
            // Kita kumpulkan semua variant_category yang unik
            $variantCategories = $product->variants->map(function ($variant) {
                $category = $variant->variantCategory;
    
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'min_selection' => $category->min_selection,
                    'max_selection' => $category->max_selection,
                    'variants' => collect($category->variants)->map(function ($v) {
                        return [
                            'id' => $v->id,
                            'name' => $v->name,
                            'price' => $v->price,
                        ];
                    })->toArray()
                ];
            })->unique('id')->values();

            $productData = [
                'id' => $product->id,
                'name' => $product->name,
                'category_id' => $product->category_id,
                'description' => $product->description,
                'photo' => $product->photo,
                'price' => $product->price,
                'status' => $product->status,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'variants' => $variantCategories,
                'likes' => $wishlistCount,
                'hasWishlist' => $hasWishlist,
            ];

            return response()->json([
                'message' => 'Product details',
                'product' => $productData
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
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
