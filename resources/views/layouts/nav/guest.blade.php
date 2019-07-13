<!-- Main menu -->
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-info text-white">
        <!-- Branding Image -->
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        <!-- Collapsed Hamburger -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        

        <div class="collapse navbar-collapse w-100" id="navbarTogglerDemo01">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav justify-content-end">
            
                <li class="nav-item" >
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
                
            </ul>
        </div>
    </nav> <!-- Nav main menu -->