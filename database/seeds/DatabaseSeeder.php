<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        factory(App\User::class, 'admin')->create();
        factory(App\User::class, 50)->create();

        $this->call(PermissionsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(CoursesStarSeeder::class);
    }
}
