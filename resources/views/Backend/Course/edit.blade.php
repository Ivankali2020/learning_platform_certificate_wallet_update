@extends('Backend.layout.app')
@section('title') ------------- &ngtr; @endsection
@section('course_create_active','mm-active ')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper ">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-disk icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <h3 class="mb-0 fw-bolder icon-gradient bg-mean-fruit ">Edit Course</h3>
            </div>

        </div>
    </div>

    <div class="container mt-3 p-0 ">
        <div class="row ">
            <div class="col-md-5  ">
                <div class="card">
                    <div class="card-body animate__animated animate__lightSpeedInRight">

                        {{-- this is form start --}}
                        <form action="{{ route('course.update',$course->id) }}"  method="post" class="form-row" id="courseEdit" enctype="multipart/form-data">
                            @csrf @method('put')
                            <div class="col-12  mb-3  ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Name</label>
                                <input type="text" name="name" value="{{ old('name',$course->name) }}" class="form-control">
                            </div>
                            <div class="col-12  mb-3  ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Price</label>
                                <input type="number" name="price" value="{{ old('price',$course->price) }}" class="form-control">
                            </div>
                            <div class="col-12 col-md-6 mb-3  ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Category</label>
                                <select name="category_id" id="" class="form-control ">
                                    <option value="" disabled selected>Select Categories</option>
                                    @forelse ($categories as $c)
                                        <option {{ old('category_id',$course->category_id) == $c->id ? 'selected' : '' }} value="{{ $course->id }}">{{ $course->name }}</option>
                                    @empty
                                        <option > Errror </option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3  ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Photo</label>
                                <input type="file" value="{{ old('photo',$course->photo) }}"  accept="image/jpeg,image/png,image/jpg"  name="photo" class="form-control p-1">
                            </div>
                            <div class="col-12 col-md-6   ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Duration</label>
                                <input type="number" value="{{ old('duration',$course->duration) }}" name="duration" class="form-control ">
                            </div>
                            <div class="col-12 col-md-6   ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Discount (%)</label>
                                <input type="number" name="discount" value="{{ old('discount',$course->discount) }}" class="form-control">
                            </div>

                        </form>
                        {{-- this is form end --}}
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-0 ">
                <div class="col-12  mb-3 ">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group animate__animated animate__lightSpeedInLeft animate__delay-1s " >
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3 " for="">Description</label>
                                <textarea id="summernote" form="courseEdit" name="description" cols="30" rows="8" >
                                     {{ old('description',$course->description) }}
                                </textarea>
                            </div>
                            <div class="form-group text-right mb-0 mt-4  "  >
                                <button form="courseEdit" class="btn btn-secondary  ">Edit Course </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    {!! JsValidator::formRequest('App\Http\Requests\UpdateCourseRequest', '#courseEdit'); !!}

@endsection



