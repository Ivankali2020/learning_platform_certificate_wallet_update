<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Enrollment;
use http\Env\Url;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $enrollmentCourses = Enrollment::when(isset(request()->search),function ($q){
                return $q->where('enrollment_id',request()->search);
            })->with('user','course')->paginate(5);
//            return $enrollmentCourses;
            return view('Backend.Enrollment.index',compact('enrollmentCourses'));

    }


    public function userEnrollment()
    {
        $enrollmentCourse = Enrollment::where('user_id',Auth::id())->where('confirm','=','1')->with('course')->get();
//        return $enrollmentCourse;
        return view('Enrollment',compact('enrollmentCourse'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEnrollmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEnrollmentRequest $request)
    {
        if(Auth::id() != $request->user_id){
            return redirect()->back()->with('message',['icon'=>'error','text'=>'something was wrong!']);
        }

        //this is for payment_photo
        if ($request->file('photo') !== null){
            $file = $request->file('photo');
            $newName = uniqid().$file->getClientOriginalName();

            Storage::putFileAs('/public/pay_ment/',$file,$newName);

            $courses = Cart::where('user_id',$request->user_id)->get();

            $check_enroll_id = Enrollment::where('user_id',Auth::id())->first();

            if ($check_enroll_id){
                $enrollment_id = $check_enroll_id->enrollment_id;
            }else{
                $enrollment_id = rand(111111,999999);
            }


            foreach ($courses as $c){
                $enrollment = new Enrollment();
                $enrollment->payment_photo = $newName;
                $enrollment->course_id = $c->course_id;
                $enrollment->user_id = Auth::id();
                $enrollment->enrollment_id = $enrollment_id;
                $enrollment->save();
            }

            $courses->each->delete();

            return redirect()->back()->with('message',['icon'=>'success','text'=>'We will permission soon!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function show(Enrollment $enrollment)
    {
//        $course = $enrollment->where()with('courseWithCurri')->get();
//        return $course;
//        return view('learn',compact('course'));
    }

    public function enrollmentCustomShow($id)
    {
//        return $id;
        $learnCourse = Course::where('id',$id)->with('curriculums')->first();
//        return $learnCourse;
        return view('learn',compact('learnCourse'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEnrollmentRequest  $request
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment)
    {
        if($request->status == '0'){
            $enrollment->confirm = '1';
            $enrollment->update();
            return response()->json(['icon'=>'success','text'=>'Process Complete']);
        }else{
            $enrollment->confirm = '0';
            $enrollment->update();
            return response()->json(['icon'=>'error','text'=>'Not Confirmed!']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
