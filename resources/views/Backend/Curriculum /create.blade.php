@extends('Backend.layout.app')
@section('title') Curriculum @endsection
@section('course_index_active','mm-active')
@section('style')

    <style>

        .note-editor .note-toolbar{
            background-color: lightskyblue;
        }
        .modal-backdrop{
            z-index: 0 !important;
        }

        .modal{
            margin-top:100px ;
            z-index: 10000!important;
        }
    </style>

@endsection
@section('content')
    <div class="app-page-title ">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit ">
                    </i>
                </div>
                <div class="icon-gradient bg-mean-fruit"> Courses Curriculum </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-0   page-title-heading mt-3 mt-md-4 ">
        <div class="row ">
            <div class="col-xl-7  ">
                <div class="card  animate__animated animate__lightSpeedInLeft "> {{--app-page-title--}}
                    <div class="card-body">
                        <form action="{{ route('curriculum.store') }}" method="post" id="createCurriculum" >
                            @csrf
                            <h4 >Curriculum For {{ $course->name }} </h4>

                            <div class="form-group">
                                <label for="">Week</label>
                                <input type="number" value="{{ old('week') }}" name="week" class="form-control">
                            </div>

                            <div class="form-group animate__animated animate__lightSpeedInLeft animate__delay-1s " >
                                <label for="">Description</label>
                                <textarea id="summernote"   cols="30" rows="8"  name="outline">
                                    {{ old('outline') }}
                                </textarea>
                            </div>


                            <div class="form-group">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button class="form-control btn btn-secondary ">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card app-page-title ">
                    <div class="card-body">
                    @forelse($curriculums as $curri)

                            <p class=" animate__animated animate__lightSpeedInLeft  ">
                                <button class="d-flex justify-content-between align-items-center btn btn-outline-secondary btn-block  "
                                        type="button" data-bs-toggle="collapse" data-bs-target="#categoryCollapse{{ $curri->id }}" aria-expanded="false" aria-controls="categoryCollapse{{ $curri->id }}">
                                   <span> Week {{ $curri->week }}</span>
                                    <span> <i class="pe-7s-angle-down fw-bolder fs-1  "></i> </span>
                                </button>
                            </p>

                            <div class="collapse mb-3 " id="categoryCollapse{{ $curri->id }}">
                                    <div class="">
                                        {!! $curri->description !!}
                                    </div>
                                    <div class="form-group text-right">
                                        <a href="{{ route('curriculum.edit',$curri->id) }}"  class="btn text-end  btn-secondary icon-gradient bg-mean-fruit fw-bolder  ">Edit</a>
                                    </div>
                            </div>



                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\StoreCourseCurriculumRequest', '#createCurriculum'); !!}

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                dialogsFade: true,
                dialogsInBody: true,
                tabsize: 2,
                codeviewFilter: false,
                codeviewIframeFilter: true,
                height: 200,
                lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    // ['table', ['table']],
                    ['height', ['height']],
                    // ['view', ['fullscreen', 'codeview', 'help']],
                    // ['insert', ['link', 'picture', 'video']],

                ],

            });
        });
    </script>
@endsection

