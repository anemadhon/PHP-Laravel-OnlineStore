<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use App\Services\ProductGalleryService;
use App\Http\Requests\User\ProductGalleryRequest;

class ProductGalleryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        $this->authorize('sell');

        return view('user.product_gallery.form', ['product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGalleryRequest $request)
    {
        $this->authorize('sell');

        $data = $request->validated();

        $data['image'] = (new ProductGalleryService())->uploadImages([
            'product_id' => $data['product_id'],
            'image' => $request->file('image')
        ]);

        ProductGallery::create($data);

        return redirect()->route('dashboard.stores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductGallery  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductGallery $gallery)
    {
        $this->authorize('sell');

        $gallery->delete();

        return redirect()->back();        
    }
}
