<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'ULPGC COURSE')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .page-break {
            page-break-after: always;
        }
        .img-center {
            display: block;
            margin: 0 auto;
        }
        .logo {
            max-width: 200px;
        }
        .separator {
            padding: 20px 50px;
        }
        .header {
            background: linear-gradient(to bottom, #002e67 0%, #42648e 100%);
            color: white;
        }
        .main {
            background-color: white;
        }
        .shadow {
            box-shadow: 0 0 5px rgba(0, 0, 0, .1);
        }
        .f-s-12px {
            font-size: 12px;
        }
        .f-s-16px {
            font-size: 16px;
        }
        .color-gray {
            color: #777;
        }
    </style>
    @yield('head', '')
</head>
<body>

    @yield('body', '')
    @yield('scripts', '')

</body>
</html>