@extends('layouts.app')
@section('style')
    <style>
        .nav-link{
            border-radius: 10px !important;
        }
        .offcanvas-backdrop.show{
            opacity: 0;
        }
        .blur{
            backdrop-filter: blur(20px) saturate(100%);
            --webkit-backdrop-filter: blur(50px) saturate(200%);
            background-color: rgba(255, 255, 255, 0.52);
            border-radius: 12px;
            border: 1px solid rgba(209, 213, 219, 0.3);
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="card p-0  overflow-hidden ">
            <div class="card-body p-0 ">
                <iframe width="100%" height="600px" class="card-img-top "
                        src="https://www.youtube.com/embed/tgbNymZ7vqY?playlist=tgbNymZ7vqY&loop=1">
                </iframe>
            </div>
        </div>
    </div>

    <button class="btn btn-outline-light position-absolute " style="top: 100px;right:0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <i class="pe-7s-left-arrow mr-5 h3 mb-0  "></i>
    </button>

    <div class="offcanvas offcanvas-end bg-transparent blur " tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header justify-content-between align-items-center mx-3  ">
            <a href="{{ route('certificate.request',$learnCourse->id) }}" id="offcanvasRightLabel mb-0">
                <img src="{{ asset('photo/certificate.png') }}" width="50" alt="">
            </a>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @forelse($learnCourse->curriculums as $outline)
            <div class="card mb-2 ">
                <div class="card-body">
                    <div class="fw-bolder">WEEK {{ $outline->week }}</div>
                    <div class="mt-4 ">
                        <ul class="p-0 " style="padding: 0">
                            <li class="mb-3 list-unstyled ">
                                <a href=""  class="text-dark d-flex text-decoration-none justify-content-between align-items-center ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="pe-7s-video mb-0 h3  mr-4"></span>
                                        <span class="text-capitalize">HTML & CSS TURORIALS</span>
                                    </div>
                                    <div class="">
                                        12:00
                                    </div>
                                </a>
                            </li>
                            <li class="mb-3 list-unstyled ">
                                <a href=""  class="text-dark d-flex text-decoration-none justify-content-between align-items-center ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="pe-7s-video mb-0 h3  mr-4"></span>
                                        <span class="text-capitalize">HTML & CSS TURORIALS</span>
                                    </div>
                                    <div class="">
                                        12:00
                                    </div>
                                </a>
                            </li>
                            <li class="mb-3 list-unstyled ">
                                <a href=""  class="text-dark d-flex text-decoration-none justify-content-between align-items-center ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="pe-7s-video mb-0 h3  mr-4"></span>
                                        <span class="text-capitalize">HTML & CSS TURORIALS</span>
                                    </div>
                                    <div class="">
                                        12:00
                                    </div>
                                </a>
                            </li>
                            <li class="mb-3 list-unstyled ">
                                <a href=""  class=" d-flex text-decoration-none justify-content-between align-items-center ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="pe-7s-video mb-0 h3  mr-4"></span>
                                        <span class="text-capitalize">HTML & CSS TURORIALS</span>
                                    </div>
                                    <div class="">
                                        12:00
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
                @empty
            @endforelse
        </div>
    </div>
@endsection

@section('script')



@endsection
