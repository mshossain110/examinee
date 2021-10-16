
<!-- Main menu -->
<nav class="navbar navbar-expand-lg sticky-top bg-primary bg-dark">
    <div class="container">
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
                    <a class="nav-link" href="{{route('instructor.courses')}}">Scholar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('learning.courses')}}">Student</a>
                </li>
                <li class="nav-item dropdown">
               
                    <a class="nav-link dropdown-toggle" id="usermenu" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ get_gravatar(Auth::user()->email) }}" class="rounded-circle"/>
                        {{ Auth::user()->name }}
                        
                    </a>
                    <div class="dropdown-menu" aria-labelledby="usermenu">
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

    </div>
</nav>