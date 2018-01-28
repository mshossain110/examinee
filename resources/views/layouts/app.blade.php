@include("layouts.header")

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-info text-white">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/exam') }}">Exam</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/topic') }}">Topic</a>
                        </li>
                        
                    </ul>
                    <ul class="navbar-nav justify-content-end">
                        @if (Auth::guest())
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ url('/login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/register') }}">Register</a>
                            </li>
                            
                        @else

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                            <div class="dropdown-menu">
                                <a href="{{ url('/logout') }}" 
                                    class="dropdown-item"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                    </form>
                            </div>
                          </li>
                        @endif
                    </ul>
                  </div>

            </div>
        </nav>

        @yield('content')
    </div>
    @include('layouts.footer')
</body>
</html>
