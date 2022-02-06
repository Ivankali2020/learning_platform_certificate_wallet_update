<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::orderBy('id','desc')->paginate(10);
        return view('Backend.Course.index',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.Course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
//        return $request;
        $file = $request->file('photo');
        $newName = uniqid().$file->getClientOriginalName();
        Storage::putFileAs('/public/coursePhoto/',$file,$newName);


        $course = new Course();
        $course->name = $request->name;
        $course->slug = \Illuminate\Support\Str::slug($request->name);

        $course->price = $request->price;
        $course->duration = $request->duration;
        $course->description = $request->description;
        $course->photo = $newName;
        $course->discount = $request->discount ?? null;
        $course->category_id = $request->category_id;
        $course->user_id = Auth::id();
        $course->save();
        return redirect()->back()->with('message',['icon'=>'success','text'=>'<h2 class="icon-gradient bg-mean-fruit">Successfully Inserted!</h2>']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('Backend.Course.edit',compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCourseRequest  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {

        $course->name = $request->name;
        $course->slug = \Illuminate\Support\Str::slug($request->name);

        if($request->hasFile('photo')){
            if($course->photo != 'course.png'){
                Storage::delete('public/coursePhoto/'.$course->photo);
            }
            $file = $request->file('photo');
            $newName = uniqid().$file->getClientOriginalName();
            Storage::putFileAs('/public/coursePhoto/',$file,$newName);

            $course->photo = $newName;

        }

        $course->price = $request->price;
        $course->duration = $request->duration;
        $course->description = $request->description;
        $course->discount = $request->discount ?? null;
        $course->category_id = $request->category_id;
        $course->update();
        return redirect()->route('course.index')->with('message',['icon'=>'success','text'=>'<h2 class="icon-gradient bg-mean-fruit">Successfully Inserted!</h2>']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if($course->photo != 'course.png'){
            Storage::delete('public/coursePhoto/'.$course->photo);
        }
        $course->delete();

        return redirect()->back()->with('message',['icon'=>'success','text'=>'Successfully Delete!']);
    }

    public function heartGive(Request $request)
    {

        if(Auth::check()){

            $user = Auth::user()->with('heart')->first();
            foreach ($user->heart as $h){
                if($h->id == $request->course_id){
                    $user->heart()->detach($request->course_id);
                    return response()->json(['success'=>'false','id'=>$request->course_id ]);
                }
            }
            $user->heart()->attach($request->course_id);
            return response()->json(['success'=>'true','id'=>$request->course_id ]);

        }else{
            return response()->json(['success'=>'error']);
        }
    }
}
