<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::when(isset(request()->role) && request()->role != 3,function ($q){
            return $q->where('role',request()->role);
        })->simplePaginate(5);
        return view('Backend.userCRUD.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.userCRUD.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        return redirect()->route('user.index')->with('message',['icon'=>'success','text'=>'successfully created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('Backend.userCRUD.edit',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(UserUpdateRequest $request,User $user)
    {
        return $user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->update();
        return redirect()->route('user.index')->with('message',['icon'=>'success','text'=>'successfully updated']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->update();
        return redirect()->route('user.index')->with('message',['icon'=>'success','text'=>'successfully updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('message',['icon'=>'success','text'=>'successfully deleted']);

    }

    public function upgradeAdmin(Request $request){
        $user = User::findOrFail($request->user_id);
        if(isset($request->admin_upgrade)){
            $user->role = '1';
            $user->update();
            return redirect()->back()->with('message',['icon'=>'success','text'=>'successfully upgraded']);
        }else{
            $user->role = '0';
            $user->update();
            return redirect()->route('user.index')->with('message',['icon'=>'success','text'=>'successfully downgraded']);

        }
    }


    public function certificate($id)
    {
        if(!Storage::exists("public/certificates")){
            Storage::makeDirectory("public/certificates");
        }

        $course = Course::findOrFail($id)->with('user')->first();
        $certificateBg = Image::make('photo/certificateCardWhite.png');
        $logo = Image::make(public_path('photo/certiPrize.png'))->fit(200,350);
        $user = User::where('id',Auth::id())->with('certificates')->first();

        foreach ($user->certificates as $c){
            if(Storage::exists('public/certificates/'.$c->certificate_unique_id.'.png')){
                $uniqueID = $c->certificate_unique_id;
                return view('Backend.certificate',compact('course','uniqueID'));
            }
        }
        $uniqueID = " UC - ".uniqid().' - '.rand(111111,999999).' - '.uniqid();

        $main = $certificateBg->text("CERTIFICATE", 580, 250, function($font) {
            $font->file(public_path('Backend/assets/roboto_black_macroman/Roboto-Black-webfont.ttf'));
            $font->size(60);
            $font->color('#00000');
            $font->align('center');
        })->text("OF COMPLETION", 470, 300, function($font) {
            $font->file(public_path('Backend/assets/roboto_black_macroman/Roboto-Regular-webfont.ttf'));
            $font->size(30);
            $font->color('#00000');
        })->text($course->name, 250, 440, function($font) {
                $font->file(public_path('Backend/assets/roboto_black_macroman/Roboto-Regular-webfont.ttf'));
                $font->size(50);
                $font->color('#00000');
        })->text('Instructor By '.$course->user->name, 250, 480, function($font) {
            $font->file(public_path('Backend/assets/roboto_black_macroman/Roboto-Thin-webfont.ttf'));
            $font->size(20);
            $font->color('#00000');
        })->text(strtoupper(Auth::user()->name), 100, 680, function($font) {
            $font->file(public_path('Backend/assets/roboto_black_macroman/Roboto-Black-webfont.ttf'));
            $font->size(40);
            $font->color('#00000');
        })->text('Date '.now()->format('d M Y'), 100, 720,function ($font){
            $font->file(public_path('Backend/assets/roboto_black_macroman/Roboto-Regular-webfont.ttf'));
            $font->size(20);
            $font->color('#00000');
        })->text('Length 30 total hours', 100, 760,function ($font){
            $font->file(public_path('Backend/assets/roboto_black_macroman/Roboto-Regular-webfont.ttf'));
            $font->size(20);
            $font->color('#00000');
        })->text($uniqueID, 1075, 670,function ($font){
            $font->file(public_path('Backend/assets/roboto_black_macroman/Roboto-Thin-webfont.ttf'));
            $font->size(20);
            $font->color('#00000');
            $font->angle(90);
        })->insert($logo,'bottom-right',180,150);

        $path = public_path('storage/certificates/');
        $main->save($path.$uniqueID.'.png',100);

        $newCertificate = new Certificate();
        $newCertificate->course_id = $course->id;
        $newCertificate->user_id = Auth::id();
        $newCertificate->certificate_unique_id = $uniqueID;
        $newCertificate->save();
//        return $main->response();
//        return $course;
        return view('Backend.certificate',compact('course','uniqueID'));
    }
}
