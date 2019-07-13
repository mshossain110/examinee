@include("layouts.header")

<body>
    
    @section('topnav')
        @if (auth()->user())
            @component('layouts.nav.auth')
            @endcomponent
        @else
            @component('layouts.nav.guest')
            @endcomponent
        @endif

        
    @show

    <div class="container-fluid" id="notify">
        <div class="row">
        @section('rightnav')
            @if (auth()->user())
            <div class="col-md-2 d-none d-md-block">
                @component('layouts.nav.right')
                @endcomponent
            </div>
                
            @endif
        @show
            

            <!-- Display body -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                @yield('content')
            </main>

        </div> <!-- End row -->
    </div> <!-- Container-fluid -->
    @include('layouts.footer')
    @stack('footer')
</body>
</html>
