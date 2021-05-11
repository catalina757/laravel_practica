@extends('layout.base')

@section('content')
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('components.topbar')
        @include('components.nav')
        <div class="content-wrapper" style="min-height: 1170.12px;">
            @yield('content')

            this will contain dashboard informations
        </div>
        @include('components.footer')


    </div>
    <!-- ./wrapper -->
@endsection
