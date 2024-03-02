@extends('dashboard.layouts.layout')

@section('container_content')
    @include('dashboard.layouts.sidebar')
    @yield('content')
    @include('dashboard.layouts.footer')
@endsection
