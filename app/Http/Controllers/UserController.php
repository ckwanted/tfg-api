<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserUpdateRequest;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $users = null;

        if($request->query('q')) {
            $q = '%'. trim( strtolower( $request->query('q') ) ) . '%';

            $users = User::whereRaw('LOWER(name) LIKE ?', [$q])
                         ->orWhereRaw('LOWER(last_name) LIKE ?', [$q])
                         ->orWhereRaw('LOWER(email) LIKE ?', [$q])
                         ->paginate(10);
        }
        else {
            $users = User::paginate(10);
        }

        foreach($users as $user) {
            $user['rol'] = $user->getRol();
        }

        return response()->json([
            'users' => $users
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
        $idValidate = null;

        if($me->getRol() == "admin") $idValidate = $user->id;
        else $idValidate = $me->id;

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $idValidate,
        ]);

        if($validator->fails()) {
            return response()->json(['error' => trans('validation.unique', ['attribute' => 'email'])], 400);
        }

        if($this->is_me($user)) {

            DB::beginTransaction();

            $user->fill($request->only('name', 'last_name', 'email'));

            if($request->rol) {
                $user->removeRole($user->getRol());
                $user->assignRole($request->rol);
            }

            $user->save();

            DB::commit();

            if($request->rol) $user['rol'] = $request->rol;
            else $user['rol'] = $user->getRol();

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
