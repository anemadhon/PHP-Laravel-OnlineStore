<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\User\PersonalInfoRequest;

class ProfileController extends Controller
{
    public function profile(User $user)
    {
        return view('profile', ['user' => $user]);
    }

    public function updateProfile(ProfileRequest $request, User $user)
    {
        $user->update($request->validated());

        if ($user->role === 'ADMIN') return redirect()->route('admin.index');

        return redirect()->route('dashboard');
    }
    
    public function updatePersonal(PersonalInfoRequest $request, User $user)
    {
        $user->update($request->validated());

        if ($user->role === 'ADMIN') return redirect()->route('admin.index');

        return redirect()->route('dashboard');
    }
}
