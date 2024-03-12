@extends('dashboard.layouts.container')
@section('content')
@section('title')
    {{ __('admin.admins') }}
@endsection
@section('body-content')
    @if (request()->is(app()->getLocale() . '/dashboard/admins') || request()->is('dashboard/admins'))
        @include('dashboard.admins.table')
    @endif

    @if (request()->is(app()->getLocale() . '/dashboard/admins/create') || request()->is('dashboard/admins/create'))
        @include('dashboard.admins.create')
    @endif

    @isset($admin->id)
        @if (request()->is(app()->getLocale() . "/dashboard/admins/$admin->id/edit") ||
                request()->is("dashboard/admins/$admin->id/edit"))
            @include('dashboard.admins.edit')
        @endif
    @endisset
@endsection
@include('dashboard.layouts.navbar')

@endsection
