@extends('dashboard.layouts.container')
@section('content')
@section('title')
    {{__('admin.services')}}
@endsection
@section('body-content')
    @if (request()->is(app()->getLocale() . '/dashboard/services') ||request()->is('dashboard/services'))
        @include('dashboard.services.table')
    @endif

    @if (request()->is(app()->getLocale() . '/dashboard/services/create') ||request()->is('dashboard/services/create'))
        @include('dashboard.services.create')
    @endif
    @isset($service->id)
        @if (request()->is(app()->getLocale() . '/dashboard/services') ||request()->is("dashboard/services/$service->id/edit"))
            @include('dashboard.services.edit')
        @endif
    @endisset
@endsection
@include('dashboard.layouts.navbar')

@endsection
