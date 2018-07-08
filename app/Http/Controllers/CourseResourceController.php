<?php

namespace App\Http\Controllers;

use App\CourseResource;
use App\CourseSection;
use App\Http\Requests\CourseResource\CourseResourceStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseResourceController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseResourceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseResourceStoreRequest $request) {

        $courseSection = CourseSection::findOrFail($request->section_id);

        if($this->is_my_course($courseSection->course) && $this->isValidData($request)) {

            $courseResource = null;

            if($request->uri) {
                $uri = $request->file('uri')->store("section/resource/{$request->section_id}", 's3');
                $courseResource = CourseResource::create([
                    "section_id" => $request->section_id,
                    "title"      => $request->title,
                    "uri"        => $uri
                ]);
            }
            else {
                $courseResource = CourseResource::create([
                    "section_id" => $request->section_id,
                    "title"      => $request->title,
                    "quiz"       => $request->quiz
                ]);
            }

            return response()->json([
                'course_resource'   => $courseResource
            ]);

        }

        return $this->responseNotPermission();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param CourseResource $courseResource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseResource $courseResource) {

        if($this->is_my_course($courseResource->course) && $this->isValidData($request)) {

            if($request->uri) {
                $uri = $request->file('uri')->store("section/resource/{$request->section_id}", 's3');

                $courseResource->fill([
                    "section_id" => $request->section_id,
                    "title"      => $request->title,
                    "uri"        => $uri,
                    "quiz"       => null
                ]);
            }
            else {
                $courseResource->fill([
                    "section_id" => $request->section_id,
                    "title"      => $request->title,
                    "uri"        => null,
                    "quiz"       => $request->quiz
                ]);
            }

            $courseResource->save();

            return response()->json([
                'course_resource'   => $courseResource
            ]);

        }

        return $this->responseNotPermission();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CourseResource $courseResource
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseResource $courseResource) {

        if($this->is_my_course($courseResource->course)) {

            try {
                $courseResource->delete();
                return response()->json([], 204);
            }
            catch (\Exception $e) {
                return response()->json(['message'  => $e->getMessage()], 400);
            }

        }

        return $this->responseNotPermission();

    }

    private function isValidData(Request $request) {
        return $request->uri || $request->quiz ? true : false;
    }

}
