<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserUpdateRequest;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

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

        if($this->is_me($user)) {

            $user->fill($request->only('name', 'last_name', 'email', 'photo'));
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
     * @throws \Exception
     */
    public function destroy(User $user) {

        try {

            if($this->is_me($user)) $user->delete();
            else throw new Exception("you don't have permission");

            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json(['message'  => $e->getMessage()], 400);
        }


    }

    /**
     * Display a listing of the teachers.
     *
     * @return \Illuminate\Http\Response
     */
    public function teachers() {

        $teacherRol = Role::findByName('teacher');

        if(!$teacherRol) return response()->json(['teachers' => []]);

        $teachers = $teacherRol->users;

        foreach($teachers as $teacher) $teacher->courses;

        return response()->json([
            'teachers' => $teacherRol->users
        ]);
    }

    public function payment() {
        return response()->json([
            'userPayments'  => auth()->user()->payments
        ]);
    }

}
