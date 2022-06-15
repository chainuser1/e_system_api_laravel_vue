<!doctype html>
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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="https://demos.creative-tim.com/light-bootstrap-dashboard/assets/css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" /> -->

    <!-- <link href="https://demos.creative-tim.com/light-bootstrap-dashboard/assets/css/demo.css" rel="stylesheet" /> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .fa {
            font-size: 1.5em;
        }
        /* turn outline for all .form-control into red */
        .form-control:focus {
            outline: none;
            border-color: #ff0000;
        }
    </style>
</head>
<body>
    <div id="app">
        <base-page :app_name="'{{config('app.name', 'Laravel')}}'"
        :root_url="'{{url('/')}}'"></base-page>
    </div>

    <script src="https://demos.creative-tim.com/light-bootstrap-dashboard/assets/js/plugins/bootstrap-switch.js"></script>
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script> -->
    <!-- <script src="https://demos.creative-tim.com/light-bootstrap-dashboard/assets/js/plugins/jquery.sharrre.js"></script> -->
    <!-- <script src="https://demos.creative-tim.com/light-bootstrap-dashboard/assets/js/plugins/bootstrap-notify.js"></script> -->

    <script src="https://demos.creative-tim.com/light-bootstrap-dashboard/assets/js/light-bootstrap-dashboard.js?v=2.0.1" type="text/javascript"></script>

    <script src="https://demos.creative-tim.com/light-bootstrap-dashboard/assets/js/demo.js"></script>
    <script   script type="text/javascript">
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            demo.initDashboardPageCharts();

            demo.showNotification();

        });
    </script>
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
