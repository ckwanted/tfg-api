<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class SearchController extends Controller {

    public function course(Request $request) {

        $q = '%'. trim(strtolower($request->q)) .'%';

        $courses = Course::with('user')
                        ->leftJoin('view_course_star', 'courses.id', '=', 'view_course_star.course_id')
                        ->where('name', 'LIKE', $q);

        /*
         * ->where(function($query) use ($q) {
                            $query->where("courses.name", 'LIKE', $q)
                                  ->orWhere("courses.description", 'LIKE', $q);
                        });
         */
        $courses = $courses->orderBy('id', 'desc')->paginate(30);

        return response()->json([
            'courses' => $courses
        ]);
    }

}
