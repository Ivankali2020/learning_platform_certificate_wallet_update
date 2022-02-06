@extends('layouts.app')
@section('style')
    <style>
        .nav-link{
            border-radius: 10px !important;
        }

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row flex-wrap ">
{{--            <div class="col-md-4">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body animate__animated animate__fadeIn">--}}
{{--                        <h3 class="fw-bolder animate__animated animate__fadeInDownBig "> Category Search </h3>--}}
{{--                        <form id="categorySearch" action="{{ route('detail.course') }}" method="get"></form>--}}
{{--                        <div class="form-group d-flex my-4 animate__animated animate__lightSpeedInLeft  ">--}}
{{--                            <input form="categorySearch"  type="text" class="form-control mr-4 " name="brandOrCategory" >--}}
{{--                            <button form="categorySearch" class="btn btn-outline-secondary px-2 pb-0  "><i class="pe-7s-search h5 "></i></button>--}}
{{--                        </div>--}}

{{--                        <div class="d-flex  " >--}}
{{--                            <p class="  animate__animated animate__lightSpeedInLeft  ">--}}
{{--                                <button class="btn btn-light " type="button" data-bs-toggle="collapse" data-bs-target="#categoryCollapse" aria-expanded="false" aria-controls="categoryCollapse">--}}
{{--                                    Categories--}}
{{--                                </button>--}}
{{--                            </p>--}}
{{--                            <p class="animate__animated animate__lightSpeedInLeft ">--}}
{{--                                <a href="{{ route('detail.course') }}" class="btn btn-secondary  "  >--}}
{{--                                    All--}}
{{--                                </a>--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                        --}}{{-- this is category collapse--}}
{{--                        <div class="collapse" id="categoryCollapse">--}}
{{--                            @foreach($categories as $c)--}}
{{--                                <a href="{{ url('/detail/course?search='.$c->id) }}" class="btn btn-block d-flex justify-content-between align-items-center ">--}}
{{--                                    <span class="text-capitalize ">{{ $c->name }} </span>--}}
{{--                                    <span class="badge badge-pill bg-light text-secondary ">{{count(\App\Models\Product::where('category_id',$c->id)->get()) }}</span>--}}
{{--                                </a>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                        --}}{{-- this is category collapse--}}


{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="card my-4 animate__animated animate__zoomInDown " style=" --animate-duration: 2s;">--}}
{{--                    <div class="card-body  ">--}}
{{--                        <h3 class="fw-bolder "> Price Search </h3>--}}
{{--                        <form action="{{ route('detail.course') }}" method="get" class="form-group row my-4  ">--}}
{{--                            <div class="col-6">--}}
{{--                                <label for="">MIN</label>--}}
{{--                                <input value="{{ old('min',request()->min) }}" type="text" name="min" class="form-control mr-4 ">--}}
{{--                            </div>--}}
{{--                            <div class="col-6 text-right ">--}}
{{--                                <label for="">Max</label>--}}
{{--                                <input value="{{ old('max',request()->max) }}" type="text" name="max" class="form-control mr-4 ">--}}
{{--                            </div>--}}
{{--                            <div class="col-12 text-center mt-4 ">--}}
{{--                                <button class="btn btn-light w-25 "> Apply </button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class=" col-md-4   mb-4 ">
                    <div class="card mb-3 animate__animated animate__fadeIn  overflow-hidden  "  >
                        <div class="text-center ">
                            <img class="card-img-top " src="{{ asset('storage/coursePhoto/'.$course->photo) }}" width="150px"alt="">
                        </div>
                        <div class="card-body   ">

                            <div class="  ">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="">
                                        <h2> {{ $course->name }}  </h2>
                                        <div class="d-flex   text-secondary ">
                                            <i class="pe-7s-star"></i>
                                            <i class="pe-7s-star"></i>
                                            <i class="pe-7s-star"></i>
                                            <i class="pe-7s-star"></i>
                                            <i class="pe-7s-star"></i>
                                        </div>
                                    </div>

                                </div>

                                <div class=" d-flex justify-content-between align-items-center mt-4 ">
                                    <div class="">
                                        @if($course->discount != null)
                                            <span class=" fw-bold text-decoration-line-through  ">${{ $course->price }}</span>
                                            <span class="h6 fw-bold text-primary   ">
                                                <span class="h5">$ </span>
                                                <span class="h5 fw-bolder " >{{ number_format( $course->price - ($course->price * $course->discount) / 100  , 2)  }}</span>
                                            </span>
                                        @else
                                            <span class="h5  fw-boldd text-primary  ">$ {{ number_format($course->price,2) }}</span>
                                        @endif
                                    </div>
                                    <div class=" ">
                                        @if( $course->discount != null )
                                            <span class="fw-boldd text-primary  ">{{  $course->discount."%"  }} </span>
                                            <span class="icon-gradient bg-mean-fruit fw-bolder ml-2  ">
                                                OFF
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="my-2">
                                    <table class="table table-borderless mb-0 mt-2 p-0  icon-gradient bg-premium-dark ">
                                        <tr>
                                            <td class="px-0 ">Teacher</td>
                                            <td class="text-right px-0 ">{{ $course->user->name }} </td>
                                        </tr>
                                        <tr>
                                            <td class="px-0 ">Duration</td>
                                            <td class="text-right px-0">{{ $course->duration == '1' ? $course->duration.' week' : $course->duration.' weeks' }} </td>
                                        </tr>
                                        <tr>
                                            <td class="px-0 ">Assignments</td>
                                            <td class="text-right px-0"> YES </td>
                                        </tr>
                                        <tr>
                                            <td class="px-0 ">Discusion Group</td>
                                            <td class="text-right px-0"> YES </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="mt-4  d-flex justify-content-between align-items-center ">
                                    @guest
                                        <a href="{{ route('register') }}" class="btn btn-secondary mr-3  btn-block  d-flex justify-content-center align-items-center " >Buy Now <i class="ml-2 pe-7s-cart bg-happy-green  h4 mb-0 icon-gradient"></i> </a>
                                    @else

                                        <button class="btn btn-secondary mr-3 fw-bolder  btn-block  d-flex justify-content-center align-items-center " onclick="allow('{{ $course->id }}','{{ $course->name }}')" >
                                            Buy Now <i class="ml-2  h4 mb-0 pe-7s-cart bg-happy-green  icon-gradient"></i>
                                        </button>

                                    @endguest
                                    <button class="btn btn-outline-light   " >
                                        <i class="fa fa-heart bg-mean-fruit h4 mb-0 icon-gradient"></i>
                                    </button>
                                </div>
                                <form id="CreateCart{{ $course->id }}" action="{{ route('cart.store') }}" method="post" class="d-inline ">
                                    @csrf <input type="hidden" name="product_id" value="{{ $course->id }}">
                                </form>
                            </div>
                        </div>
                    </div>

            </div>

            <div class="col-md-8 mb-4">
                 <div class="card">
                    <div class="card-body  ">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">အကျဉ်းချူပ်</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">သင်ရိုးများ</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">သင်ကြားမှုပုံစံ</button>
                            </li>
                        </ul>

                        <div class="tab-content " id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="card">
                                    <div class="card-body   ">
                                        {!! $course->description !!}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade  " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                @forelse($course->curriculums as $curri)
                                    <div class="card mt-3 ">
                                        <div class="card-body pb-1    ">
                                            <h4 class="fw-bolder "> Week {{ $curri->week }} </h4>
                                            {!! $curri->description !!}
                                        </div>
                                    </div>
                                @empty
                                @endforelse

                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                                <div class="card card-body ">
                                    သင်တန်းအပ်နှံအပြီး Admin တွေဘက်မှလက်ခံပေးပြီးသည်နှင့်တစ်ပြိုင်နက် Week 1 to 8 Lecture videos တွေကို မိမိဘာသာ အစအဆုံး အစဉ်လိုက်စတင်လေ့လာနိုင်ပြီဖြစ်ပါတယ်။ Assignment တင်ရန်နှင့် မေးခွန်းမေးရန်အတွက် Facebook Group တစ်ခုဖန်တီးပေးထားပါသည်။
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).on('click',function(){
            $('.collapse').collapse('hide');
            console.log('.saldjfas')
        })
    </script>

@endsection
