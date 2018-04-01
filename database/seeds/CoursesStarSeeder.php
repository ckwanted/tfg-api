<?php

use App\Course;
use App\CourseStar;
use Illuminate\Database\Seeder;

class CoursesStarSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $courses = Course::all();

        foreach($courses as $course) {

            CourseStar::create([
                'course_id' => $course->id,
                'user_id'   => 2,
                'value'     => rand(1, 5)
            ]);

            CourseStar::create([
                'course_id' => $course->id,
                'user_id'   => 3,
                'value'     => rand(1, 5)
            ]);

        }

    }

}
