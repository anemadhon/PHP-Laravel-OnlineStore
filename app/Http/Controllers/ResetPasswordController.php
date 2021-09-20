<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPwdRequest;

class ResetPasswordController extends Controller
{
    public function index(User $user)
    {
        return view('reset-pwb', ['user' => $user]);
    }

    public function resetPassword(ResetPwdRequest $request, User $user)
    {
        $data = $request->validated();

        if (!Hash::check($data['current_password'], $user->password)) 
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        
        $user->password = Hash::make($data['password']);

        $user->save();

        if ($user->role === 'ADMIN') return redirect()->route('admin.index');

        return redirect()->route('dashboard');

    }
}
