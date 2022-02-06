@extends('Backend.layout.app')
@section('title') Order @endsection
@section('style')
    <style>
        .line{
            height: 5px;
            /*background-color: black;*/
            z-index: -1;
            width: 50%;
        }
        .line .btn{
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .search{
            position: absolute;
            top: 30px;
            right: 30px;

        }
        .pagination{
            margin: 0;
        }
    </style>
@endsection
@section('order_index_active','mm-active')
@section('content')
    <div class="app-page-title ">
        <div class="page-title-wrapper d-flex justify-content-between align-items-center ">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit ">
                    </i>
                </div>
                <a href="{{ route('enrollment.index') }}" class="icon-gradient bg-mean-fruit"> Order List </a>
            </div>
            <div class="">

            </div>
        </div>
    </div>

    <div class="container-fluid p-0   page-title-heading mt-3 mt-md-4 ">
        <div class="row ">
            <div class="col-xxl-10  m-auto ">
                <div class="card app-page-title  " style="border-radius: 20px" >
                    <div class="card-body  ">

{{--                        <div class="d-flex justify-content-between align-items-center bg-happy-fisher mt-3 line">--}}
{{--                            <a href="{{ route('order.index') }}" class="btn btn-light   ">--}}
{{--                                <img src="{{ asset('photo/order.png') }}" width="100%" alt="">--}}
{{--                            </a>--}}

{{--                            <a href="{{ url('/order?status='.'1') }}" class="btn btn-light ">--}}
{{--                                <img src="{{ asset('photo/clipboard.png') }}" width="100%" alt="">--}}
{{--                            </a>--}}
{{--                            <a href="{{ url('/order?status='.'2') }}" class="btn btn-light ">--}}
{{--                                <img src="{{ asset('photo/fast-delivery.png') }}" width="100%" alt="">--}}
{{--                            </a>--}}
{{--                            <a href="{{ url('/order?status='.'3') }}" class="btn btn-light  ">--}}
{{--                                <img src="{{ asset('photo/check.png') }}" width="100%" alt="">--}}
{{--                            </a>--}}
{{--                        </div>--}}

                        <div class="search">
                            <form action="{{ url('/enrollment') }}" method="get" class="d-flex ">
                                <input type="text" value="{{ request()->search ?? '' }}" name="search" class="form-control">
                                <button  class="btn btn-outline-light ml-2  "><i class="pe-7s-search fs-4 icon-gradient bg-happy-itmeo "></i></button>
                            </form>
                        </div>


                        <table class="table mt-5  table-bordered  p-0  mt-3 table-responsive-md  " id="dataTable">
                            <thead class="fw-bolder bg-light   ">
                            <tr >
                                <td>Enrollment ID</td>
                                <td >Customer</td>
                                <td>Payment</td>
                                <td>Phone</td>
                                <td>Course</td>
                                <td>Date Order</td>
                                <td class="no-sort text-nowrap" >Status</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($enrollmentCourses as $key=>$enrollment)
                                <tr class="animate__animated animate__fadeInLeftBig" style="--animate-duration: {{ $key+1 }}s">
                                    <td class="fw-bolder ">{{ $enrollment->enrollment_id }}</td>
                                    <td >{{ $enrollment->user->name }}</td>
                                    <td>
                                        <img src="{{ asset('storage/pay_ment/'.$enrollment->payment_photo) }}" width="150" alt="">
                                    </td>
                                    <td>{{ $enrollment->user->phone}}</td>
                                    <td>
                                        <div class="text-capitalize"> {{ $enrollment->course->name ?? '' }}</div>
                                    </td>

                                    <td>
                                        {{ $enrollment->created_at->format('M d Y') }}
                                    </td>
                                    <td class="text-center ">
                                        <div class="form-check form-switch ">
                                            <input type="hidden" value="{{ $enrollment->confirm }}" name="confirm_status">
                                            <input id="enroll{{ $enrollment->id }}" class="form-check-input" onchange="allowForEnrollConfirm('{{ $enrollment->id }}','{{ $enrollment->confirm }}')" {{  $enrollment->confirm == 1 ? 'checked' : '' }}  type="checkbox" role="switch"  >
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
{{--                        {{ $enrollmentCourses->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{--    <script>--}}
    {{--        Swal.fire({--}}
    {{--            position: 'top-end',--}}
    {{--            icon: 'success',--}}
    {{--            title: 'Your work has been saved',--}}
    {{--            showConfirmButton: false,--}}
    {{--            timer: 1500--}}
    {{--        })--}}
    {{--    </script>--}}

    <script>
        function allowForEnrollConfirm(id,status){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('#CreateCart'+name);
                    $.ajax({
                        url: "/enrollment/"+id,
                        type : 'put',
                        dataType : 'json',
                        data:{
                            enrollment_id : id , status : status , "_token" : " {{ csrf_token() }}"
                        },
                        success:function (data){
                            console.log(data);
                            if(data.icon == 'success'){
                                Swal.fire(
                                    'Everything OK!',
                                    data.text,
                                    data.icon
                                )
                            }else {
                                Swal.fire(
                                    'something was wrong!',
                                    data.text,
                                    data.icon
                                )
                            }

                        }

                    });

                }
            })
        }
    </script>


@endsection
