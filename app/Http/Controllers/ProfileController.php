<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'two_factor_enabled' => 'boolean',
        ]);

        $user->two_factor_enabled = $request->has('two_factor_enabled');
        $user->save();

        $status = $user->two_factor_enabled ? 'enabled' : 'disabled';

        return redirect()->route('profile.edit')->with('success', "Two-Factor Authentication has been {$status} successfully.");
    }
}
