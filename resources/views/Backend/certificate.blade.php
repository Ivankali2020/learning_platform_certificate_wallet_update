<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ivan') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('Backend/css/main.css') }}">
    {{--    <script src="{{ asset('Backend/assets/scripts/main.js') }}"></script>--}}



    @yield('style')
    <style>
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius:10px;
        }
        ::-webkit-scrollbar-thumb:hover {

            background: #555;
        }
        .card,.navbar{
            backdrop-filter: blur(50px) saturate(200%);
            --webkit-backdrop-filter: blur(50px) saturate(200%);
            background-color: rgba(255, 255, 255, 0.52);
            border-radius: 12px;
            border: 1px solid rgba(209, 213, 219, 0.3);
        }

        .form-control{
            background-color: #fdfdfd00 !important;
            border: 1px solid #8ec5fc !important;
        }
        .bg-deep-blue{
            background-image: linear-gradient(278deg, #e0c3fc 0%, #8ec5fc 100%) !important;
        }

        .lds-facebook {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }
        .lds-facebook div {
            display: inline-block;
            position: absolute;
            left: 8px;
            width: 16px;
            background: #fff;
            animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
        }
        .lds-facebook div:nth-child(1) {
            left: 8px;
            animation-delay: -0.24s;
        }
        .lds-facebook div:nth-child(2) {
            left: 32px;
            animation-delay: -0.12s;
        }
        .lds-facebook div:nth-child(3) {
            left: 56px;
            animation-delay: 0;
        }
        @keyframes lds-facebook {
            0% {
                top: 8px;
                height: 64px;
            }
            50%, 100% {
                top: 24px;
                height: 32px;
            }
        }
        .loader{
            width: 100%;
            height: 100vh;
            position: absolute;
            background-color: black;
            z-index: 90;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .loader.close{
            display: none;
        }

        .animate__animated{
            animation-delay: 1s;
        }
    </style>
</head>
<body class="bg-deep-blue   ">
<div class="loader">
    <div class="lds-facebook"><div></div><div></div><div></div></div>
    <div class="fw-bolder " style="letter-spacing: 8px;"> <span class="text-white fs-1 ">L</span>oading ........</div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12 flex-column  d-flex justify-content-center align-items-center min-vh-100  ">
            <div class="card overflow-hidden " style="width: 600px;height: 471px">
                <img src="{{ asset('storage/certificates/'.$uniqueID.'.png') }}" width="100%" height="100%"  alt="">
            </div>
            <div>
                <a href="{{ asset('storage/certificates/'.$uniqueID.'.png') }}" download class="btn btn-light mt-3 "  >Download Your Certificate</a>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Laravel Javascript Validation -->
{{--    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>--}}
@yield('script')

{{--this is for session alert with toast--}}
{{--@include('Backend.layout.flash')--}}
{{--@include('components.alert')--}}
@include('components.message')
<script>

    window.addEventListener('load',function (){
        $(".loader").fadeOut(1000);
    })
    function allow(id,name){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Add To Cart'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('#CreateCart'+name);
                $.ajax({
                    url: "{{ route('cart.store') }}",
                    type : 'post',
                    dataType : 'json',
                    data:{
                        course_id : id , "_token" : " {{ csrf_token() }}"
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
</body>
</html>
