@extends('layouts.app')
@section('style')

    <style>
        body{
            background-image: url("{{ asset('photo/bgBody.jpg') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

            backdrop-filter: blur(50px) saturate(200%);
            --webkit-backdrop-filter: blur(50px) saturate(200%);
            background-color: rgba(255, 255, 255, 0.52);
            border-radius: 12px;
            border: 1px solid rgba(209, 213, 219, 0.3);
        }
        .card {
            backdrop-filter: blur(50px) saturate(200%);
            --webkit-backdrop-filter: blur(50px) saturate(200%);
            background-color: rgba(255, 255, 255, 0.52);
            border-radius: 12px;
            border: 1px solid rgba(209, 213, 219, 0.3);
            overflow: hidden;
        }
        .form-control{
            border: 1px solid #0080ff !important;
        }
        .discount{

        }
    </style>
    @endsection
@section('content')
    <div class="container">
        <div class="row flex-wrap justify-content-center ">
            @foreach($courses as $key=>$c)

                <div class=" col-9 mb-4    col-md-4 col-xl-3  text-center  ">
                    <div class="card position-relative " style="height: 300px">
                        {{--hear button and discount --}}
                        <button id="heart{{ $c->id }}"
                                class="btn btn-light p-1 px-2 icon-gradient  position-absolute  @foreach($c->heart as $h) @if($h->id == \Illuminate\Support\Facades\Auth::id())  bg-mean-fruit   @endif @endforeach "
                                onclick="heart('{{ $c->id }}')" style="top: 10px;left: 10px;z-index: 3" >
                            <i class="fa fa-heart">
                                <sup id="heartCount{{ $c->id }}" class="text-dark icon-gradient bg-mean-fruit  fw-bolder "> {{ count($c->heart) == 0 ? '' : count($c->heart)  }}  </sup>
                            </i>
                        </button>

                        @if($c->discount != null)
                        <div class="position-absolute fw-bolder discount icon-gradient bg-happy-green  "
                              style="top: 10px;right: 10px;z-index:4">
                            {{  $c->discount." % " }}
                            <div class="icon-gradient  bg-mean-fruit">
                                OFF
                            </div>
                        </div>
                        @endif
                        {{--  hear button and discount --}}

                        <div class="text-center ">
                            <img  src="{{ asset('storage/coursePhoto/'.$c->photo) }}" class="animate__animated animate__zoomInDown card-img-top " height="150px"  width="100%"  alt="">
                        </div>
                        <div class="card-body animate__animated animate__bounceIn d-flex flex-column justify-content-between ">

                            <div class="">
                                <h6 class="icon-gradient bg-happy-itmeo"> {{ $c->name }} </h6>
                                <div class="d-flex mt-2 mb-4 icon-gradient bg-happy-itmeo">
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>

                            <div class=" d-flex justify-content-between align-items-center ">
                                <div class=" ">
                                   <span class="h4 fw-bolder icon-gradient  bg-happy-itmeo  "> $ </span>
                                    @if($c->discount != null)
                                        <span class=" fw-bold text-decoration-line-through  ">{{ $c->price }}</span>
                                        <span class="h6 fw-bold icon-gradient  bg-happy-itmeo ">{{ number_format( $c->price - ($c->price * $c->discount) / 100  , 2)  }}</span>
                                    @else
                                        <span class="h6 fw-bold icon-gradient bg-happy-itmeo  ">{{ number_format($c->price,2) }}</span>
                                    @endif
                                </div>
                                <div class="">
                                        <a href="{{ url('detail/course?detail='.$c->id) }}" class="btn btn-outline-secondary p-1 px-2 " >  <i class="pe-7s-info  "></i>  </a>
                                    @guest
                                        <a href="{{ route('login') }}" class="btn btn-light p-1 px-2 " > <i class="pe-7s-cart icon-gradient bg-happy-green"></i> </a>
                                    @else

                                        <button class="btn btn-outline-light   p-1 px-2 " onclick="allow('{{ $c->id }}','{{ $c->name }}')" > <i class="pe-7s-cart icon-gradient bg-happy-fisher fw-bolder  "></i> </button>

                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endsection
@section('script')

    <script>
        function heart(id){
            $.ajax({
                url : "{{ route('course.heart') }}",
                type : 'post',
                dataType : 'json',
                data : { course_id : id , '_token' : "{{ csrf_token() }}" },
                success: function (data){
                    console.log(data);
                    if(data.success == 'true'){
                        $('#heart'+data.id).addClass('bg-mean-fruit');
                        let count = $('#heartCount'+data.id).html();
                        console.log( $('#heartCount'+data.id).html(++count) );
                    }else if(data.success == 'error'){
                        window.location.href = '{{ route('login') }}'
                    }else{
                        $('#heart'+data.id).removeClass('bg-mean-fruit');
                        let count = $('#heartCount'+data.id).html();

                        let no = --count;
                        console.log(no);
                        if(no == '0'){
                            $('#heartCount'+data.id).html('');
                        }else{
                            $('#heartCount'+data.id).html(no);
                        }
                    }
                }
            })
        }
    </script>

@endsection
