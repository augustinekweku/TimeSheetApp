<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Styles -->
        <script src="https://use.fontawesome.com/c509eae645.js"></script>
        <link rel="stylesheet" href="/css/all.css">
        <title>Time Sheet</title>
        <script>
            (function () {
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                }
            })();
        </script>
    </head>
    <body>
        <div id="app">
            <mainapp></mainapp>
        </div>
    </body>
    <script src="{{mix('/js/app.js')}}"></script>
    <script src="{{mix('/assets/js/push.min.js')}}"></script>
    
    <script>
        //Push.create('Welcome Shailesh!', {
            //  body: "Welcome to the Dashboard",
            //timeout: 5000
        //})
    </script>

</html>
