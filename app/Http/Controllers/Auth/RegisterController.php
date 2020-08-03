<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class RegisterController extends Controller
{

    public function register (Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => ucwords(strtolower($request->name)),
            'email' => trim(strtolower($request->email)),
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('app-token');

        $response = [
            'user' => $user,
            'access_token' => $token->plainTextToken
        ];

        return response()->json($response, 201);
    }
}