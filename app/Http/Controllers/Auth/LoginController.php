<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{
    public function login (Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|max:255'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password))
        {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 401);
        }

        $token = $user->createToken('app-token');

        $response = [
            'user' => $user,
            'access_token' => $token->plainTextToken
        ];

        return response($response, 201);
    }
}