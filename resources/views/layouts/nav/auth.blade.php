
<!-- Main menu -->
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-info text-white">
        <!-- Branding Image -->
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        <!-- Collapsed Hamburger -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        
        

        <div class="collapse navbar-collapse d-flex justify-content-between">
            <form class="form-inline flex-nowrap input-group-lg col-6">
                <div class="input-group w-100">
                    <input type="text" class="form-control" placeholder="Search courses" aria-label="Search" aria-describedby="search">
                    <div class="input-group-prepend">
                        <button class="input-group-text" id="search"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/')}}"> <i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)"> <i class="fas fa-th"></i> Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Scholar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Student</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ get_gravatar(Auth::user()->email) }}" class="rounded-circle"/>
                        {{ Auth::user()->name }}
                        
                    </a>
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
                
            </ul>
        </div>
    </nav> <!-- Nav main menu -->

    <!-- <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/exam') }}">Exam</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/subject') }}">Subject</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/topic') }}">Topic</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/question') }}">Question</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/courses') }}">coursed</a>
                </li>
            </ul> -->