@extends('Backend.layout.app')
@section('title') Courses @endsection
@section('course_index_active','mm-active')
@section('content')
    <div class="app-page-title ">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit ">
                    </i>
                </div>
                <div class="icon-gradient bg-mean-fruit"> Courses List </div>
            </div>
        </div>
    </div>

    <div class="container-fluid page-title-heading mt-3 mt-md-4 ">
        <div class="row">
            <div class="col-xxl-10 p-0  m-auto ">
                <div class="card app-page-title p-0">
                    <div class="card-body  p-0">
                        <table class="table  table-bordered mb-0  p-0 table-responsive-md  icon-gradient bg-mean-fruit" id="dataTable" >
                            <thead class="fw-bolder  ">
                            <tr class="fw-bolder h6 ">
                                <td>#</td>
                                <td >Name</td>
                                <td>Price</td>
                                <td>User</td>
                                <td>Category</td>
                                <td>Duration</td>
                                <td>Discount</td>
                                <td>Photo</td>
                                <td>Control</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td style="width: 200px;">{{ $course->name }}</td>
                                    <td>{{ $course->price }} <span calss="text-right ">$</span></td>
                                    <td>{{ $course->user->name }}</td>
                                    <td>{{ $course->category->name }} </td>
                                    <td>{{ $course->duration == '1' ? $course->duration.' week' : $course->duration.' weeks' }}  </td>
                                    <td>
                                        {{ $course->discount ?? 'no' }}
                                    </td>
                                    <td class="text-center ">
                                        <img src="{{ asset('storage/coursePhoto/'.$course->photo) }}" width="50px" alt="">
                                    </td>

                                    <td class="flex-nowrap">
                                        <a href="{{ route('course.edit',$course->id) }}" class="pe-7s-pen h4 "></a>
                                        <a href="{{ route('course.show',$course->id) }}" class="pe-7s-info h4  ml-3  "></a>
                                        <a href="{{ route('custom.create',$course->id) }}" class="pe-7s-more h4 mx-3   "></a>
                                        <form class="d-inline "  id="deleteProduct{{$course->id}}" action="{{ route('course.destroy',$course->id) }}" method="post">
                                            @csrf @method('delete')
                                            <span style="cursor: pointer" onclick="allow('{{ $course->name }}',{{ $course->id }})"> <i class="pe-7s-trash h4 "></i> </span>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{  $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

    {{--    {!! JsValidator::formRequest('App\Http\Reques   ts\StoreCategoryRequest', '#createCategory'); !!}--}}
    <script>
        function allow(name,id){

            Swal.fire({
                title: 'Are you sure?',
                text: name,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('#deleteProduct'+id)
                    $('#deleteProduct'+id).submit();
                }
            })
        }
    </script>

@endsection

