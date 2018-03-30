<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $adminRole = Role::create(['name' => 'admin']);
        $teacherRole = Role::create(['name' => 'teacher']);
        $studentRole = Role::create(['name' => 'student']);

        $users = User::all();
        $i = 0;

        foreach($users as $user) {

            if($user->id == 1) $user->assignRole('admin');
            else if($i < 10) $user->assignRole('teacher');
            else $user->assignRole('student');

            $i++;
        }

    }
}
