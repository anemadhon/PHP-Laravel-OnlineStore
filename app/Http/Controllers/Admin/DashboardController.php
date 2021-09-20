<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $this->authorize('into-admin');

        $users = Transaction::selectRaw('count(user_id) as active_user, user_id')->groupBy('user_id')->orderByDesc('active_user')->first();
        
        $activeUser = User::select('name')->find($users->user_id);

        $products = TransactionDetail::selectRaw('count(product_id) as fav_product, product_id, count(transaction_id) as transaction_count')->groupBy('product_id')->orderByDesc('fav_product')->first();
        
        $favCategory = Product::with('category')->find($products->product_id);

        $stores = TransactionDetail::selectRaw('count(store_id) as fav_store, store_id, count(transaction_id) as transaction_count, count(distinct transaction_id) as customer, sum(purchase_price * purchase_quantity) as revenue')->groupBy('store_id')->orderByDesc('fav_store')->first();
        
        $favStore = Store::select('name')->find($stores->store_id);
        
        $storesRevenue = TransactionDetail::selectRaw('count(store_id) as fav_store, store_id, sum(purchase_price * purchase_quantity) as revenue')->groupBy('store_id')->orderByDesc('revenue')->first();
        
        $favStoreRevenue = Store::select('name')->find($storesRevenue->store_id);

        return view('admin.dashboard', [
            'user_active' => $activeUser->name,
            'user_transaction' => $users->active_user,
            'favorite_category' => $favCategory->category->name,
            'category_transaction' => $products->transaction_count,
            'favorite_store' => $favStore->name,
            'store_transaction' => $stores->transaction_count,
            'store_customer' => $stores->customer,
            'store_revenue_name' => $favStoreRevenue->name,
            'store_revenue' => $storesRevenue->revenue
        ]);
    }
}
