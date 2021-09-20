<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use App\Models\Cart;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Models\TransactionDetail;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaction.index', [
            'transactions' => auth()->user()->transactions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $carts = auth()->user()->carts->load('product');

        $max = $carts->sum('total_each_product') + $request->inscurance_price + $request->shipping_price;

        $validated = Validator::make($request->all(), [
            'inscurance_price' => "required|integer",
            'shipping_price' => "required|integer|",
            'total_price' => "required|integer|size:$max"
        ]);

        if ($validated->fails()) 
            return redirect()->back()->withErrors($validated);
        
        $dataValidated = $validated->validated();

        return (new TransactionService())->checkout([
            'validated' => $dataValidated,
            'carts' => $carts
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Transaction $transaction)
    {
        return view('transaction.show', [
            'user_address' => (new CartService())->createAddressFormat($user),
            'transaction' => $transaction->load('details')
        ]);
    }

    public function callback()
    {
       (new MidtransService())->callbackHandling();
    }
}
