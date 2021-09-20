<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        $this->authorize('into-admin');

        $stores = Store::with(['user', 'category', 'products']);

        $stores->when(request('search') ?? false, fn($query, $key) => 
            $query->where('name', 'like', '%'.$key.'%')
        );

        return view('admin.store.index', [
            'stores' => $stores->paginate(6)
        ]);
    }

    public function show(Store $store)
    {
        $this->authorize('into-admin');

        $products = $store->products()->with(['category', 'galleries'])
                        ->withSum(['details as purchase_quantity' => 
                            fn($query) => 
                                $query->where('shipping_status', '<>', 'CANCELLED')
                            ], 'purchase_quantity');

        $products->when(request('search') ?? false, fn($query, $key) => 
            $query->where('name', 'like', '%'.$key.'%')
                    ->orWhere('description', 'like', '%'.$key.'%')
        );

        return view('admin.store.show', [
            'store' => $store,
            'products' => $products->paginate(5)
        ]);
    }
}
