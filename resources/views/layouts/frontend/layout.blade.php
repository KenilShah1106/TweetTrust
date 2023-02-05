<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Bootstrapp css -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    @yield('page-level-styles')

</head>
<body>
    <!-- Header -->
    @include('layouts.frontend.partials._header')

    <!-- Redesigned Main content -->
    <div class="main-body">
        <div class="row">
            <div class="col-half p-0">
                @include('layouts.frontend.partials._left-sidebar')
            </div>
            <div class="col-11 hero p20">
                <div class="row hero-header mx-0 mb8 justify-content-between">
                    <div class="col-9 p-0 hero-header-left">
                        @yield('hero-header-left')
                    </div>
                    <div class="col-3 text-right p-0 hero-header-right">
                        @yield('hero-header-right')
                    </div>
                </div>
                <hr>

                <div class="hero-body mt20">
                    @include('layouts.frontend.partials._message')
                    @yield('hero-body')
                </div>
                <div class="hero-footer mt16">
                    @yield('hero-footer')
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    @include('layouts.frontend.partials._footer')

    <!-- Bootstrap JS -->
    <script src="{{asset('js/app.js')}}"></script>

    @yield('page-level-scripts')
   <script>
        $("#tweetBtn").click(function (e) {
            filter = new Filter();
            $body = $("#body").val();
            $filteredBody = filter.clean($body);
            console.log(e);
            if($body != $filteredBody) {
                window.alert("Hate speech recognized");
                e.preventDefault();
            } 
        });
   </script>
</body>
</html>
