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
