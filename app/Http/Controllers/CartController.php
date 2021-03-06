<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartRequest $request)
    {
        if(!Auth::check()){
            return response()->json(['icon'=>'question','text'=>'something was wrong!']);
        }
        //ဆိုလိုတာက ခြင်းတောင်းထဲမှာ ရှိတဲ့ order_id က ထပ်မထပ်စစ်တာပါ
        $carts = Cart::where('user_id',Auth::id())
            ->whereExists(function ($q){
            return $q->where('course_id',request()->course_id);
        })->get();

        if(count($carts) > 0){
            return response()->json(['icon'=>'question','text'=>'Your Already Added']);
        }

        $cart = new Cart();
        $cart->course_id = $request->course_id;
        $cart->user_id = Auth::id();
        $cart->save();
        return response()->json(['icon'=>'success','text'=>'Successfully Added']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCartRequest  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $cart->quality = $request->quality;
        $cart->update();

        $carts = Cart::where('user_id',Auth::id())->get();
        $products = $carts->mapToGroups(function ($p,$price){
            $qulityMultipleByProduct = $p['product']['price'] * $p['quality'] ;
            $dividedByOnehundred = ($qulityMultipleByProduct * $p['product']['discount'] )/ 100;
            return ['price' =>  $qulityMultipleByProduct - $dividedByOnehundred ];
        });
        $a = $products->toArray()['price'];
        $total = array_sum($a);

        return json_encode(['total'=>"$total"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('message',['icon'=>'success','text'=>'Successfully Deleted']);
    }
}
