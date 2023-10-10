<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('vendor/DevsBuddy/crudgen/images/logo.png') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ config('crudgen.home') ? config('crudgen.home') : url('/') }}">Home</a>
                </li> --}}
                <li class="nav-item @if(\Route::currentRouteName() == 'crudgen.index') active @endif }}">
                    <a class="nav-link" href="{{ route('crudgen.index') }}">Crud</a>
                </li>
            </ul>
        </div>
    </div>
</nav>