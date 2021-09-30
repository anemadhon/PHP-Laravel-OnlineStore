<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserDashboard;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()->transactions;

        $stores = (new UserDashboard())->getStoreStatistic([
            'has_store' => auth()->user()->has_store,
            'store' => auth()->user()->has_store ? auth()->user()->store : null
        ]);

        return view('user.dashboard', [
            'last_transaction' => $transactions->last(),
            'favorite_category' => (new UserDashboard())->getFavoriteCategory($transactions->pluck('id')->all()),
            'favorite_store' => (new UserDashboard())->getFavoriteStore($transactions->pluck('id')->all()),
            'store_revenue' => $stores['revenue'],
            'store_active_customer' => $stores['active_customer']
        ]);
    }
}
