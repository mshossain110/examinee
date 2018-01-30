@include("layouts.header")

<body>
    <div class="wrapper">
        
        <!-- Sidebar -->
        <nav id="sidebar" class="navbar navbar-expand-lg navbar-dark bg-info text-white">
            <div id="dismiss">
                <i class="glyphicon glyphicon-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Home</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li><a href="#">Home 1</a></li>
                        <li><a href="#">Home 2</a></li>
                        <li><a href="#">Home 3</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">About</a>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li><a href="#">Page 1</a></li>
                        <li><a href="#">Page 2</a></li>
                        <li><a href="#">Page 3</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Portfolio</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-dark bg-info text-white">

                <!-- sidebarCollapse button -->
                <div class="navbar-header">
                    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button class="navbar-toggler main-nav-collapse" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
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
    </div>
    @include('layouts.footer')
</body>
</html>
