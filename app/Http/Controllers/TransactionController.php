<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\CartService;
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
            'shipping_price' => "required|integer",
            'total_price' => "required|integer|size:$max"
        ]);

        if ($validated->fails()) 
            return back()->withErrors($validated);
        
        $dataValidated = $validated->validated();

        DB::beginTransaction();
        
        try
        {
            $transaction = (new TransactionService())->checkout([
                'user_id' => auth()->id(),
                'validated' => $dataValidated,
                'carts' => $carts
            ]);

            $payment = (new MidtransService())->createTransaction([
                'order_id' => $transaction->unique_number,
                'gross_amount' => $dataValidated['total_price'],
                'user_name' => auth()->user()->name,
                'user_email' => auth()->user()->email
            ]);

            if ($payment['status'])
            {
                DB::commit();
                
                return redirect($payment['url']);
            }
            
            if (!$payment['status'])
            {
                DB::rollback();

                return back()->withErrors($payment['error']);
            }
        }
        catch (\Exception $error)
        {
            DB::rollback();

            return $error->getMessage();
        }
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
            'user_address' => (new CartService())->createAddressFormat([
                'address_one' => $user->address_one,
                'address_two' => $user->address_two,
                'provincy' => $user->provincy,
                'regency' => $user->regency,
                'zip_code' => $user->zip_code,
                'country' => $user->country,
                'phone_number' => $user->phone_number
            ]),
            'transaction' => $transaction->load('details')
        ]);
    }

    public function callback()
    {
       (new MidtransService())->callbackHandling();
    }
}
