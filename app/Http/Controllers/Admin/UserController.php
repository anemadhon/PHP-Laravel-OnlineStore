<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('into-admin');

        $users = User::with('store');

        $users->when(request('search') ?? false, fn($query, $key) =>
            $query->where(fn($query) => 
                $query->where('name', 'like', '%'.$key.'%')
                        ->orWhere('username', 'like', '%'.$key.'%')
                        ->orWhere('email', 'like', '%'.$key.'%')
            )
        );

        return view('admin.user.index', [
            'users' => $users->paginate(6)
        ]);
    }

    public function show(User $user)
    {
        $this->authorize('into-admin');

        return view('admin.user.show', [
            'user' => $user
        ]);
    }
}
