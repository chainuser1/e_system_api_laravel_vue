<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">



    <!-- Styles -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ionicon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- <link href="https://demos.creative-tim.com/light-bootstrap-dashboard/assets/css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />

    <link href="https://demos.creative-tim.com/light-bootstrap-dashboard/assets/css/demo.css" rel="stylesheet" />  -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link href="{{ asset('css/font-awesome4.7.min.css') }}" rel="stylesheet"> -->
    <style>
        .fa {
            font-size: 1.5em;
        }
        /* turn outline for all .form-control into red */
        .form-control:focus {
            outline: none;
            border-color: #ff0000;
        }
        .main-page{
            /* background-image: url("{{url('assets/background')}}") !important; */
            max-height: 200vh;
            height:35em;
            background-size: cover;
        }
    </style>
</head>
<body  class="hold-transition sidebar-mini">
    <!-- <div class="main-page">

    </div> -->
    <div id="app" class="wrapper">
        <base-page :app_name="'{{config('app.name', 'Laravel')}}'"
        :root_url="'{{url('/')}}'"></base-page>
    </div>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- <script src="{{asset('js/bootstrap.min.js')}}"></script> -->
    <script src="{{asset('js/aminlte.js')}}"></script>
    <script src="{{asset('js/chart.min.js')}}"></script>
    <script src="{{asset('js/mangampo.min.js')}}"></script>
    <script>
        // window Auth
        window.Auth = {!! json_encode([
            'user' => Auth::guard('web')->user(),
            'loggedIn' =>  Auth::guard('web')->check()
        ]) !!};

        window.Urls = @json([
            'api'=> url('/api'),
            'login'=> url('/api/login'),
        ]);
        window.Laravel = @json([
            'csrfToken' => csrf_token()
        ]);
        console.log(window.Auth);
    </script>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
