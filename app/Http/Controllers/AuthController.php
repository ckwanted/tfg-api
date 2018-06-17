<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthenticateUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Mail\RegisterMail;
use App\User;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller {

    /**
     * Get a JWT via given credentials.
     *
     * @param AuthenticateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthenticateUserRequest $request) {

        $credentials = $request->only(['email', 'password']);

        if(!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Register a new user
     *
     * @param RegisterUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request) {

        $user = User::create($request->all());

        Mail::to($user->email)->send(new RegisterMail($user));

        return response()->json([
            'user'    => $user
        ], 201);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {
        $user = auth()->user();
        $rol = $user->getRol();

        return response()->json([
            'user'           => $user,
            'rol'            => $rol,
            'access_token'   => $token,
            'expires_in'     => auth()->factory()->getTTL() * 60
        ]);
    }

}
