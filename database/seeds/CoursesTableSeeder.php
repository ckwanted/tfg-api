<?php

use App\Course;
use App\CourseResource;
use App\CourseSection;
use App\User;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $users = User::with('roles')->get();

        $faker = Faker\Factory::create("es_ES");

        foreach($users as $user) {

            if($user->getRol() == 'teacher') {

                $course = Course::create([
                    'user_id'       => $user->id,
                    'name'          => $faker->name,
                    'description'   => $faker->text,
                ]);

                for($i = 1; $i < 3; $i++) {

                    $section = CourseSection::create([
                        'course_id' => $course->id,
                        'title'     => $faker->title . " $i"
                    ]);

                    for($y = 1; $y < 3; $y++) {

                        CourseResource::create([
                            'section_id' => $section->id,
                            'title'      => $faker->title . " $i",
                            'type'       => config('constant.course_type')[0],
                            'uri'        => $faker->url
                        ]);

                        CourseResource::create([
                            'section_id' => $section->id,
                            'title'      => $faker->title . " $i",
                            'type'       => config('constant.course_type')[1],
                        ]);

                    }

                }

            }

        }

    }
}
