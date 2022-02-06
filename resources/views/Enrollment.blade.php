@extends('layouts.app')
@section('style')

    <style>
        body{
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

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row flex-wrap align-items-center vh-100">
            @forelse($enrollmentCourse as $key=>$c)

                <div class=" col-6 col-md-5 col-xl-3  mb-4  ">
                    <div class="card position-relative " style="height: 350px">

                        <div class="text-center ">
                            <img  src="{{ asset('storage/coursePhoto/'.$c->course->photo) }}" class="animate__animated animate__zoomInDown card-img-top " height="150px"  width="100%"  alt="">
                        </div>
                        <div class="card-body animate__animated animate__bounceIn d-flex flex-column justify-content-between ">

                            <div class="">
                                <h6 class="bg-premium-dark icon-gradient "> {{ $c->course->name }} </h6>
                                <div class="d-flex my-3 bg-premium-dark icon-gradient ">
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center ">
                                    <a href="{{ url('detail/course?detail='.$c->course->id) }}" class="btn btn-outline-secondary p-1 px-2 mr-2 " > Detail <i class="pe-7s-info  "></i>  </a>
                                    <a href="{{ route('enrollment.custom.show',$c->course->id)  }}" class="btn btn-success p-1 px-2 " > Learn <i class="pe-7s-bookmarks  "></i>  </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card  card-body py-5   " >
                    <div class="text-center  icon-gradient bg-mixed-hopes ">
                        <div class="fa fa-sad-cry h1"></div>
                        <div class="h4 fw-bolder mt-4 " style="letter-spacing: .8rem;"> THERE IS NO COURSES </div>
                    </div>
                </div>
            @endforelse
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
