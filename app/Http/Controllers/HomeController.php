<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Course;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(Auth::user()->role == 1){
            return view('Backend.home');
        }

        return $this->welcome();
    }

    public function welcome()
    {
        $courses = Course::orderBy('id','desc')->with('heart')->paginate(8);
//        return $courses;
        return view('welcome',compact('courses'));
    }

    public function detail()
    {
//        $courses = Course::when(isset(request()->search),function ($q){
//                $data = request()->search;
//                return $q->where('category_id',"=","$data");
//            })
//            ->when(isset(request()->brandOrCategory),function ($q){
//                $brand = request()->brandOrCategory;
//                return $q->where('name',"LIKE","%$brand%");
//            })
//            ->when(isset(request()->min),function ($q){
//                $min = request()->min;
//                $max = request()->max;
//                return $q->where('price','<=',"$max")->where('price','>=',"$min");
//            })
//            ->paginate(1);

        $course = Course::where('id',request()->detail)->with(['curriculums','user','category'])->first();

//        return $course;
        return view('detailCourse',compact('course'));
    }

    public function UserCart()
    {
        $carts = Cart::where('user_id',Auth::id())->get();

        if(count($carts) > 0) {
            $products = $carts->mapToGroups(function ($p, $price) {
                $qulityMultipleByCourse = $p['course']['price'] * $p['quality'] ;
                $dividedByOnehundred = ($qulityMultipleByCourse * $p['course']['discount'] )/ 100;
                return ['price' =>  $qulityMultipleByCourse - $dividedByOnehundred ];
            });
            $a = $products->toArray()['price'];
            $total = array_sum($a);
            return view('cart', compact('carts', 'total')); //take cart in database
        }

        return view('cart', compact('carts')); //take cart in database

    }
}
