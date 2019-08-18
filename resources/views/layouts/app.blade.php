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

            
            <!-- Display body -->
            <main role="main" class="mian" >
                @yield('content')
            </main>
        </div>
    </div>
    
    @include('layouts.footer')
    @stack('footer')
</body>
</html>