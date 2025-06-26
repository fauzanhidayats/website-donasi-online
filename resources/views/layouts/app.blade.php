<!DOCTYPE html>
<html lang="en">
@include('partials.header')

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('partials.topbar')

            @include('partials.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            @include('partials.footer')
        </div>
    </div>

    @include('partials.scripts')
</body>

</html>
