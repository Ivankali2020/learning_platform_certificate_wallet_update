<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseCurriculumRequest;
use App\Http\Requests\UpdateCourseCurriculumRequest;
use App\Models\Course;
use App\Models\CourseCurriculum;
use App\Models\User;

class CourseCurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.Curriculum .create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCourseCurriculumRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseCurriculumRequest $request)
    {

        $curri = new CourseCurriculum();
        $curri->week = $request->week;
        $curri->description = $request->outline;
        $curri->course_id = $request->course_id;
        $curri->save();

        return redirect()->back()->with('message',['icon'=>'success','text'=>'Successfully Inserted']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseCurriculum  $courseCurriculum
     * @return \Illuminate\Http\Response
     */
    public function show(CourseCurriculum $courseCurriculum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseCurriculum  $courseCurriculum
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $curriculum = CourseCurriculum::findOrFail($id);
        $curriculums = CourseCurriculum::where('course_id',$curriculum->course_id)->get();

        return view('Backend.Curriculum .edit',compact('curriculum','curriculums'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCourseCurriculumRequest  $request
     * @param  \App\Models\CourseCurriculum  $courseCurriculum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCourseCurriculumRequest $request)
    {
        $curri = CourseCurriculum::findOrFail($request->curriculum_id);

        $curri->week = $request->week;
        $curri->description = $request->outline;
        $curri->update();

        return redirect()->route('custom.create',$curri->course_id)->with('message',['icon'=>'success','text'=>'Successfully Updated']);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseCurriculum  $courseCurriculum
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseCurriculum $courseCurriculum)
    {
        //
    }

    public function customCreate($id)
    {
        $course = Course::findOrFail($id);
        $curriculums = CourseCurriculum::where('course_id',$course->id)->get();

        return view('Backend.Curriculum .create',compact('course','curriculums'));
//        return $curriculum;

    }
}
