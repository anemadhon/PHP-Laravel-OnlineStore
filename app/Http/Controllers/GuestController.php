<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;

class GuestController extends Controller
{
    public function products()
    {
        $products = Product::with(['category', 'store', 'galleries'])
                            ->withSum(['details as purchase_quantity' => 
                                fn($query) => 
                                    $query->where('shipping_status', '<>', 'CANCELLED')
                                ], 'purchase_quantity');

        $products->when(request('search') ?? false, fn($query, $key) => 
            $query->where(fn($query) =>
                $query->where('name', 'like', '%'.$key.'%')
                        ->orWhere('description', 'like', '%'.$key.'%')
                        ->orWhereHas('category', fn($query) => 
                            $query->where('name', $key)
                        )
                        ->orWhereHas('store', fn($query) => 
                            $query->where('name', $key)
                        )
            )
        );

        return view('guest.index', [
            'products' => $products->paginate(12)
        ]);
    }

    public function productDetails(Product $product)
    {
        return view('guest.show-product', [
            'product' => $product->load(['store', 'category', 'galleries'])
                                ->loadSum(['details as purchase_quantity' => 
                                    fn($query) => 
                                        $query->where('shipping_status', '<>', 'CANCELLED')
                                    ], 'purchase_quantity')
        ]);
    }

    public function storeDetails(Store $store)
    {
        $products = $store->products()->with(['category', 'galleries']);

        $products->when(request('search') ?? false, fn($query, $key) => 
            $query->where('name', 'like', '%'.$key.'%')
                    ->orWhere('description', 'like', '%'.$key.'%')
        );

        return view('guest.show-store', [
            'store' => $store->load(['user', 'category']),
            'products' => $products->paginate(6)
        ]);
    }
}
