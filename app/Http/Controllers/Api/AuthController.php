<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    public function register(Request $request) {

        $user = User::create($request->all());
        $token =  $user->createToken(env('APP_NAME'))->accessToken;

        return response()->json([
            'token' => $token,
            'user'  => $user
        ], 200);

    }

    public function login(Request $request) {

        if(Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();
            $token =  $user->createToken(env('APP_NAME'))->accessToken;

            return response()->json([
                'token' => $token,
                'user'  => $user
            ], 200);

        }

        return response()->json(['error' => 'Unauthorised'], 401);

    }

}
