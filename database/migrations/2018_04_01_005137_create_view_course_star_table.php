<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewCourseStarTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::statement("
            CREATE VIEW view_course_star AS 
            SELECT course_id, ROUND( AVG(value), 1) AS star, COUNT(course_id) AS votes
            FROM course_stars
            GROUP BY course_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement("DROP VIEW IF EXISTS view_course_star");
    }
}
