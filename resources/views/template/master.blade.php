<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('sass/header-style.css')}}">
    <link rel="stylesheet" href="{{asset('sass/footer-style.css')}}">
    <link rel="stylesheet" href="{{asset('sass/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
    <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyByAzf9EtR4u6mMHIVUt9dKdtxxMRGVVBI",
            authDomain: "bs-tpa-web.firebaseapp.com",
            databaseURL: "https://bs-tpa-web.firebaseio.com",
            projectId: "bs-tpa-web",
            storageBucket: "bs-tpa-web.appspot.com",
            messagingSenderId: "373322654175"
        };
        firebase.initializeApp(config);
    </script>
    <title>Working Hard</title>
</head>
<body>

    @include('template.header')
    <div id="container">
        @yield('content')
    </div>
    @include('template.footer')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="{{asset('js/header.js')}}"></script>
    <script src="{{asset('js/chat.js')}}"></script>
    <script src="{{asset('js/chatList.js')}}"></script>
    <script src="{{asset('js/settings.js')}}"></script>
    <script src="{{asset('js/company.js')}}"></script>
    <script src="{{asset('js/feeds.js')}}"></script>
    <script src="{{asset('js/searchList.js')}}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>