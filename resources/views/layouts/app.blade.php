@include("layouts.header")

<body>
    <div class="wrap">
        <div id="app">
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
                    <!-- Display body -->
                    <main role="main" class="col">
                        @yield('content')
                    </main>
                </div> <!-- End row -->
            </div> <!-- Container-fluid -->
        </div>
    </div>
    
    @include('layouts.footer')
    @stack('footer')
</body>
</html>
