<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Models\Category;
use App\Models\Store;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('sell');

        $store = auth()->user()->store;

        $products = $store->products()->with('galleries')
                        ->withSum(['details as purchase_quantity' => 
                            fn($query) => 
                                $query->where('shipping_status', '<>', 'CANCELLED')
                            ], 'purchase_quantity');
        
        $products->when(request('search') ?? false, fn($query, $key) => 
            $query->where('name', 'like', '%'.$key.'%')
                    ->orWhere('description', 'like', '%'.$key.'%')
        );

        return view('user.store.index', [
            'store' => $store,
            'products' => $products->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.store.form', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        
        auth()->user()->has_store = 1;

        auth()->user()->update();

        auth()->user()->store()->create($data);
        
        return redirect()->route('dashboard.stores.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        $products = $store->products()->with(['category', 'galleries'])
                        ->withSum(['details as purchase_quantity' => 
                            fn($query) => 
                                $query->where('shipping_status', '<>', 'CANCELLED')
                            ], 'purchase_quantity');

        $products->when(request('search') ?? false, fn($query, $key) => 
            $query->where('name', 'like', '%'.$key.'%')
                    ->orWhere('description', 'like', '%'.$key.'%')
        );

        return view('user.store.show', [
            'store' => $store,
            'products' => $products->paginate(5)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        $this->authorize('sell');

        return view('user.store.form', [
            'categories' => Category::all(),
            'store' => $store
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Store $store)
    {
        $this->authorize('sell');
        
        $store->update($request->validated());

        return redirect()->route('dashboard.stores.index');
    }
}
