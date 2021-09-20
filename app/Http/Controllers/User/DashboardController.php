<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserDashboard;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()->transactions;

        $stores = (new UserDashboard())->getStoreStatistic(auth()->user());

        return view('user.dashboard', [
            'last_transaction' => $transactions->last(),
            'favorite_category' => (new UserDashboard())->getFavoriteCategory($transactions),
            'favorite_store' => (new UserDashboard())->getFavoriteStore($transactions),
            'store_revenue' => $stores['revenue'],
            'store_active_customer' => $stores['active_customer']
        ]);
    }
}
