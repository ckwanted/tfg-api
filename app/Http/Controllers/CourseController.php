<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStar;
use App\Http\Requests\Course\CourseStoreRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use App\Http\Requests\Course\CourseVoteRequest;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $courses = Course::with('user')
                        ->leftJoin('view_course_star', 'courses.id', '=', 'view_course_star.course_id');

        if($request->query('q')) {
            $q = '%'. trim( strtolower( $request->query('q') ) ) . '%';
            $courses->whereRaw('LOWER(courses.name) LIKE ?', [$q]);
        }

        if($request->query('categories')) {
            $categories = explode(',', $request->query('categories'));

            $courses->where(function($query) use ($request, $categories) {
                foreach($categories as $category) {
                    $query->orWhere('courses.category', $category);
                }
            });
        }

        if($request->query('skill_level')) {
            $skill_level = explode(',', $request->query('skill_level'));

            $courses->where(function($query) use ($request, $skill_level) {
                foreach($skill_level as $skill) {
                    $query->orWhere('courses.skill_level', $skill);
                }
            });
        }

        return response()->json([
            'userPayments'  => $this->userPayments(),
            'courses'       => $courses->orderBy('id', 'desc')
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
            'userPayments'  => $this->userPayments(),
            'my_vote'       => $this->getMyVote($course),
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

        $course = Course::with(['user', 'sections', 'sections.resources', 'myVote'])
                        ->leftJoin('view_course_star', 'courses.id', '=', 'view_course_star.course_id')
                        ->where($search, $slugOrId)
                        ->first();

        return response()->json([
            'userPayments'  => $this->userPayments(),
            'my_vote'       => $this->getMyVote($course),
            'course'        => $course
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
                'userPayments'  => $this->userPayments(),
                'my_vote'       => $this->getMyVote($course),
                'course'        => $course
            ]);
        }

        return $this->responseNotPermission();
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

    /**
     * Change photo
     *
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function photo(Request $request, Course $course) {

        if($this->is_my_course($course)) {

            if($request->file('photo')) {

                $uri = $request->file('photo')->store("courses/{$course->id}", 's3');
                Storage::disk('s3')->delete($course->photo);

                $course->update([
                    'photo' => $uri
                ]);

                return response()->json([
                    'userPayments'  => $this->userPayments(),
                    'my_vote'       => $this->getMyVote($course),
                    'course'        => $course
                ]);

            }

        }

        return $this->responseNotPermission();
    }

    /**
     * Vote course
     *
     * @param CourseVoteRequest $request
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function vote(CourseVoteRequest $request, Course $course) {
        $courseStar = CourseStar::where('user_id', auth()->user()->id)
                                ->where('course_id', $course->id)
                                ->first();

        if($courseStar) {
            CourseStar::where('user_id', auth()->user()->id)
                      ->where('course_id', $course->id)
                      ->update(['value' => $request->vote]);
        }
        else {
            CourseStar::create([
                'user_id'   => auth()->user()->id,
                'course_id' => $course->id,
                'value'     => $request->vote,
            ]);
        }

        return response()->json([
            'message'       => 'Voted correctly',
            'my_vote'       => $this->getMyVote($course),
        ]);
    }

    /**
     * My Course
     *
     * @return \Illuminate\Http\Response
     */
    public function myCourse() {

        $courses = Course::with('user')
                         ->leftJoin('view_course_star', 'courses.id', '=', 'view_course_star.course_id')
                         ->where('id', auth()->user()->id)
                         ->distinct();

        return response()->json([
            'courses'       => $courses->get(),
            'userPayments'  => auth()->user()->payments
        ]);
    }

    /**
     * Get my vote
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    private function getMyVote($course) {
        $my_vote = null;

        if($course) {
            $courseStart = DB::table('course_stars')->where('course_id', $course->id)
                ->where('user_id', auth()->user()->id)
                ->first();

            if($courseStart) $my_vote = $courseStart->value;
        }

        return $my_vote;
    }

}
