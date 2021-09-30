<?php

namespace App\Services;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class UserDashboard
{
    public function getFavoriteCategory(array $transactions_id)
    {
        if (count($transactions_id) > 0)
        {
            $transactionDetailsProduct = TransactionDetail::selectRaw('count(product_id) as fav_product, product_id')->whereIn('transaction_id', $transactions_id)->groupBy('product_id')->orderByDesc('fav_product');
        
            return Product::with('category.name')->find($transactionDetailsProduct->pluck('product_id')->first());
        }
    
        return null;
    }

    public function getFavoriteStore(array $transactions_id)
    {
        if (count($transactions_id) > 0)
        {
            $transactionDetailsStore = TransactionDetail::selectRaw('count(store_id) as fav_store, store_id')->whereIn('transaction_id', $transactions_id)->groupBy('store_id')->orderByDesc('fav_store');
            
            return Store::select('name')->find($transactionDetailsStore->pluck('store_id')->first());
        }
        
        return null;
    }

    public function getStoreStatistic(array $user)
    {
        if ($user['has_store'])
        {
            $store = $user['store']->load('details')->loadSum('details as revenue', 'total_each_product');
            
            $transactionOwner = Transaction::selectRaw('count(user_id) as fav_customer, user_id')->whereIn('id', $store->details->pluck('transaction_id')->all())->groupBy('user_id')->orderByDesc('fav_customer');
            
            return [
                'revenue' => $store->revenue,
                'active_customer' => User::select('name')->find($transactionOwner->pluck('user_id')->first())
            ];
        }

        return [
            'revenue' => null,
            'active_customer' => null
        ];
    }
}
