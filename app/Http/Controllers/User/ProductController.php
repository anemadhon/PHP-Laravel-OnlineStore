<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProductRequest;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        $products = Product::with(['category', 'galleries'])
                            ->withSum(['details as purchase_quantity' => 
                                fn($query) => 
                                    $query->where('shipping_status', '<>', 'CANCELLED')
                                ], 'purchase_quantity');

        $products->when(request('search') ?? false, fn($query, $search) =>
            $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
        );
        
        $products->when(request('category') ?? false, fn($query, $slug) =>
            $query->whereHas('category', fn($query) => 
                $query->where('slug', $slug)
            )   
        );

        return view('user.product.index', [
            'categories' => $categories,
            'products' => $products->paginate(12)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('sell');

        $store = auth()->user()->store;

        return view('user.product.form', ['store' => $store]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $this->authorize('sell');

        Product::create($request->validated());

        return redirect()->route('dashboard.stores.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('user.product.show', [
            'product' => $product->loadSum(['details as purchase_quantity' => 
                                    fn($query) => 
                                        $query->where('shipping_status', '<>', 'CANCELLED')
                                    ], 'purchase_quantity')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('sell');

        $store = auth()->user()->store;

        $galleries = $product->galleries()->get();

        return view('user.product.form', [
            'galleries' => $galleries,
            'product' => $product->loadSum(['details as purchase_quantity' => 
                            fn($query) => 
                                $query->where('shipping_status', '<>', 'CANCELLED')
                            ], 'purchase_quantity'),
            'store' => $store
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('sell');

        $product->update($request->validated());

        return redirect()->route('dashboard.stores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('sell');

        $product->delete();

        return redirect()->route('dashboard.stores.index');        
    }
}
