<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\Course\CourseStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json([
            'courses'   => DB::table('courses')
                               ->select('courses.*', 'view_course_star.star', 'view_course_star.votes')
                               ->leftJoin('view_course_star', 'courses.id', '=', 'view_course_star.course_id')
                               ->orderBy('id', 'desc')
                               ->paginate(30)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseStoreRequest $request) {

        $request['user_id'] = auth()->user()->id;
        $course = Course::create($request->all());

        return response()->json([
            'course' => $course
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course) {
        return response()->json([

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course) {
        return response()->json([

        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course) {
        return response()->json([], 204);
    }
}
