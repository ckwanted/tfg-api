<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\Course\CourseStoreRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class CourseController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json([
            'courses'   => Course::with('user')
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
     * @param $slugOrId
     * @return \Illuminate\Http\Response
     */
    public function show($slugOrId) {

        $search = is_numeric($slugOrId) ? 'courses.id' : 'courses.slug';

        $course = Course::with(['user', 'sections', 'sections.resources'])
                        ->leftJoin('view_course_star', 'courses.id', '=', 'view_course_star.course_id')
                        ->where($search, $slugOrId)
                        ->get();

        return response()->json([
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseUpdateRequest $request
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseUpdateRequest $request, Course $course) {

        if($this->is_my_course($course)) {

            $course->fill($request->all());
            $course->save();

            return response()->json([
                'course' => $course
            ]);
        }

        return response()->json([
            'message' => 'you don\'t have permission'
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course) {
        try {
            if($this->is_my_course($course)) $course->delete();
            else throw new Exception("you don't have permission");
            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json(['message'  => $e->getMessage()], 400);
        }

    }
}
