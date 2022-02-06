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
                <div class="card app-page-title animate__animated animate__lightSpeedInLeft "> {{--app-page-title--}}
                    <div class="card-body">
                        <form action="{{ route('curriculum.update',$curriculum->id) }}" method="post" id="updateCurriculum" >
                            @csrf @method('patch')
                            <h4 >Curriculum For {{ $curriculum->course->name }} </h4>

                            <div class="form-group">
                                <label class="fw-bolder mt-3  icon-gradient bg-mean-fruit " for="">Week</label>
                                <input type="number" value="{{ old('week',$curriculum->week) }}" name="week" class="form-control">
                            </div>

                            <div class="form-group animate__animated animate__lightSpeedInLeft animate__delay-1s " >
                                <label class="fw-bolder mt-3  icon-gradient bg-mean-fruit " for="">Description</label>
                                <textarea id="summernote"   cols="30" rows="8"  name="outline">
                                    {{ old('outline',$curriculum->description) }}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="curriculum_id" value="{{ $curriculum->course_id }}">
                                <button class="form-control btn btn-secondary ">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card app-page-title  p-0 ">
                    <div class="card-body p-0 ">
                            <div class="accordion accordion-flush " id="accordionFlushExample">
                                @forelse($curriculums as $curri)

                                <div class="accordion-item ">
                                    <h2 class="accordion-header " id="flush-heading{{ $curri->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $curri->id }}" aria-expanded="false" aria-controls="flush-collapse{{ $curri->id }}">
                                            Week {{ $curri->week }}
                                        </button>
                                    </h2>
                                    <div id="flush-collapse{{ $curri->id }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $curri->id }}" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            {!! $curri->description !!}
                                        </div>

                                        <div class="form-group text-right mx-4 ">
                                            <a href="{{ route('curriculum.edit',$curri->id) }}"  class="btn text-end  btn-secondary icon-gradient bg-mean-fruit fw-bolder  ">Edit</a>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateCourseCurriculumRequest', '#updateCurriculum'); !!}


@endsection

