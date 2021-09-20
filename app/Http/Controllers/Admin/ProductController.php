<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $this->authorize('into-admin');

        $products = Product::with(['category', 'galleries'])
                            ->withSum(['details as purchase_quantity' => 
                                fn($query) => 
                                    $query->where('shipping_status', '<>', 'CANCELLED')
                                ], 'purchase_quantity');

        $products->when(request('search') ?? false, fn($query, $search) =>
            $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
        );

        return view('admin.product.index', [
            'products' => $products->paginate(12)
        ]);
    }

    public function show(Product $product)
    {
        return view('admin.product.show', [
            'product' => $product->loadSum(['details as purchase_quantity' => 
                                    fn($query) => 
                                        $query->where('shipping_status', '<>', 'CANCELLED')
                                    ], 'purchase_quantity')
        ]);
    }
}
