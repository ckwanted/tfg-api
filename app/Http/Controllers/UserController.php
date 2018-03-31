<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserUpdateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json([
            'users' => DB::table('users')->paginate(30)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        return response()->json([
            'user'  => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user) {

        $me = auth()->user();

        if( ($me->getRol() == "admin") || ($me->id == $user->id)) {

            $user->fill($request->only('name', 'last_name', 'email', 'password'));
            $user->save();

            return response()->json([
                'user'  => $user
            ]);

        }

        return response()->json(['error' => 'Forbidden'], 403);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        return response()->json([], 204);
    }
}
