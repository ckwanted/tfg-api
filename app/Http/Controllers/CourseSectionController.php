<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseSection;
use App\Http\Requests\CourseSection\CourseSectionStoreRequest;
use Illuminate\Http\Request;

class CourseSectionController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseSectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseSectionStoreRequest $request) {

        $course = Course::findOrFail($request->course_id);

        if($this->is_my_course($course)) {

            $courseSection = CourseSection::create($request->all());

            return response()->json([
                'course_section'    => $courseSection
            ]);

        }

        return $this->responseNotPermission();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param CourseSection $courseSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseSection $courseSection) {

        $course = Course::findOrFail($courseSection->course_id);

        if($this->is_my_course($course)) {

            $courseSection->update($request->only('title'));

            return response()->json([
                'course_section'    => $courseSection
            ]);

        }

        return $this->responseNotPermission();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CourseSection $courseSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseSection $courseSection) {

        $course = Course::findOrFail($courseSection->course_id);

        if($this->is_my_course($course)) {

            try {
                $courseSection->delete();
                return response()->json([], 204);
            }
            catch (\Exception $e) {
                return response()->json(['message'  => $e->getMessage()], 400);
            }

        }

        return $this->responseNotPermission();

    }

}
