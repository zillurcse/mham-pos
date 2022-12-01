<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Web</title>

       {{-- Laravel Mix - CSS File --}}
      {{-- <link rel="stylesheet" href="{{asset('modules/web/css/app.css') }}">--}}
        <link rel="stylesheet" href="{{asset('modules/web/css/app.css') }}">

    </head>
    <body>
        @yield('content')

        {{-- Laravel Mix - JS File --}}
       <script src="{{Module:: asset('web::js/web.js?v=' . $asset_v) }}"></script>
    </body>
</html>
