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
                <h3 class="mb-0 fw-bolder icon-gradient bg-mean-fruit ">Create Course</h3>
            </div>

        </div>
    </div>

    <div class="container mt-3 p-0 ">
        <div class="row ">
            <div class="col-md-5  ">
                <div class="card">
                    <div class="card-body">

                        {{-- this is form start --}}
                        <form action="{{ route('course.store') }}"  method="post" class="form-row" id="courseCreate" enctype="multipart/form-data">
                            @csrf
                            <div class="col-12  mb-3  ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                            </div>
                            <div class="col-12  mb-3  ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Price</label>
                                <input type="number" name="price" value="{{ old('price') }}" class="form-control">
                            </div>
                            <div class="col-12 col-md-6 mb-3  ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Category</label>
                                <select name="category_id" id="" class="form-control ">
                                    <option value="" disabled selected>Select Categries</option>
                                    @forelse ($categories as $c)
                                        <option {{ old('category_id') == $c->id ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                    @empty
                                        <option > Errror </option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3  ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Photo</label>
                                <input type="file" value="{{ old('photo') }}"  accept="image/jpeg,image/png,image/jpg"  name="photo" class="form-control p-1">
                            </div>
                            <div class="col-12 col-md-6   ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Duration</label>
                                <input type="number" value="{{ old('duration') }}" name="duration" class="form-control ">
                            </div>
                            <div class="col-12 col-md-6   ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Discount (%)</label>
                                <input type="number" name="discount" value="{{ old('discount') }}" class="form-control">
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
                               <label class="h6 fw-bolder icon-gradient bg-mean-fruit  " for="">Description</label>
                               <textarea id="summernote" form="courseCreate"  cols="30" rows="8"  name="description">
                                    {{ old('description') }}
                                </textarea>
                           </div>
                           <div class="form-group text-right mb-0 mt-4  "  >
                               <button form="courseCreate" class="btn btn-secondary  ">Create Course </button>
                           </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    {!! JsValidator::formRequest('App\Http\Requests\StoreCourseRequest', '#courseCreate'); !!}

@endsection



