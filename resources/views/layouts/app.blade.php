<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SAMIO OBAH') }} - {{ config('app.description', 'Toko Mini Online Omah Barokah') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

        @stack('head.scripts')
    </head>
    <body>
        <div id="app">
            <x-navbar/>

            <main class="py-4">
                @yield('content')
            </main>

            <div class="text-center text-muted font-weight-bolder mb-4">
                Hubungi via WA: <a href="https://wa.me/6287879720004" title="Hubungi via WhatsApp" rel="nofollow" target="_blank">087879720004</a>
            </div>
        </div>

        <script src="{{ mix('/js/manifest.js') }}"></script>
        <script src="{{ mix('/js/vendor.js') }}"></script>
        <script src="{{ mix('/js/app.js') }}"></script>

        @stack('footer.scripts')
    </body>
</html>
