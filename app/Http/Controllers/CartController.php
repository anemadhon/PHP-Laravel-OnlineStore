<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = auth()->user()->carts->load(['product', 'product.store.user', 'product.galleries']);

        return view('cart', [
            'carts' => $carts,
            'user_address' => (new CartService())->createAddressFormat([
                'address_one' => auth()->user()->address_one,
                'address_two' => auth()->user()->address_two,
                'provincy' => auth()->user()->provincy,
                'regency' => auth()->user()->regency,
                'zip_code' => auth()->user()->zip_code,
                'country' => auth()->user()->country,
                'phone_number' => auth()->user()->phone_number
            ])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $product->loadSum(['details as purchase_quantity' => 
                    fn($query) => 
                        $query->where('shipping_status', '<>', 'CANCELLED')
                    ], 'purchase_quantity');

        $max = $product->quantity - $product->purchase_quantity;

        $validated = Validator::make($request->all(), [
            'purchase_quantity' => "required|integer|min:1|max:$max"
        ]);

        if ($validated->fails()) 
            return redirect()->back()->withErrors($validated);

        (new CartService())->updateOrCreateCart([
            'product_id' => $product->id,
            'purchase_quantity' => $validated->validated()['purchase_quantity']
        ]);

        return redirect()->route('dashboard.users.carts.index', auth()->user());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->back();
    }
}
