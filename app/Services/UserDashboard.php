<?php

namespace App\Services;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class UserDashboard
{
    public function getFavoriteCategory(object $transactions)
    {
        if ($transactions->count() > 0)
        {
            $transactionDetailsProduct = TransactionDetail::selectRaw('count(product_id) as fav_product, product_id')->whereIn('transaction_id', $transactions->pluck('id')->all())->groupBy('product_id')->orderByDesc('fav_product');
        
            return Product::with('category')->find($transactionDetailsProduct->pluck('product_id')->first());
        }
    
        return null;
    }

    public function getFavoriteStore(object $transactions)
    {
        if ($transactions->count() > 0)
        {
            $transactionDetailsStore = TransactionDetail::selectRaw('count(store_id) as fav_store, store_id')->whereIn('transaction_id', $transactions->pluck('id')->all())->groupBy('store_id')->orderByDesc('fav_store');
            
            return Store::select('name')->find($transactionDetailsStore->pluck('store_id')->first());
        }
        
        return null;
    }

    public function getStoreStatistic(object $user)
    {
        if ($user->has_store)
        {
            $store = TransactionDetail::with('stores')
                                ->whereHas('stores', fn($query) => 
                                    $query->where('store_id', $user->store->id)
                                );
            
            $transactionOwner = Transaction::selectRaw('count(user_id) as fav_customer, user_id')->whereIn('id', $store->pluck('transaction_id')->all())->groupBy('user_id')->orderByDesc('fav_customer');

            return [
                'revenue' => $store->value(DB::raw('SUM(purchase_price * purchase_quantity)')),
                'active_customer' => User::select('name')->where('id', $transactionOwner->pluck('user_id')->first())->first()
            ];
        }

        return [
            'revenue' => null,
            'active_customer' => null
        ];
    }
}
