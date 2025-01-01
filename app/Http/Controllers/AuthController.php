<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function handleLogin(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->only(['email', 'password']);
        // dd($credentials);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('admin')->with('success', 'Connexion réussie.');
        } else {
            return redirect()->back()->with('error', 'Données incorrectes');
        }
    }

    public function handleRegister(RegisterRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $request['avatar'] = $avatarPath;
            // dd('file');
        }

        try {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'avatar' => $request['avatar'] ?? null,
                'password' => Hash::make($request['password']),
                'role' => 'seller',
                'is_active' => true,
                'address' => $request['address'],
                'telephone' => $request['telephone'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating user',
                'error' => $e->getMessage()
            ], 500);
        }

        if ($user) {
            Seller::create([
                'user_id' => $user->id,
                'shop_name' => $request['shop_name'],
                'shop_address' => $request['shop_address'],
            ]);

            Auth::login($user);
            return redirect('/admin');
        }

        return redirect()->back()->with('error', 'Données incorrectes');
    }
}
