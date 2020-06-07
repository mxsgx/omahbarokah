<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('/img/logo.png') }}" width="30" height="30" class="d-inline-block align-middle" alt="Logo {{ config('app.name') }}" loading="lazy">
            <span class="align-middle">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @foreach($leftItems as $item)
                    @if(isset($item['auth']) && $item['auth'])
                        @auth
                            @if($roleGranted($item))
                                <li class="nav-item">
                                    <a class="nav-link {{ $isActive($item['route']) ? 'active' : '' }}" href="{{ route($item['route']) }}">{{ $item['name'] }}</a>
                                </li>
                            @endif
                        @endauth
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ $isActive($item['route']) ? 'active' : '' }}" href="{{ route($item['route']) }}">{{ $item['name'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrasi</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Keluar
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
