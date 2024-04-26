@extends('dashboard.layouts.container')
@section('content')
@section('title')
    {{ __('admin.specialists') }}
@endsection
@section('body-content')
    @if (request()->is(app()->getLocale() . '/dashboard/specialists') || request()->is('dashboard/specialists'))
        @include('dashboard.specialists.table')
    @endif

    @if (request()->is(app()->getLocale() . '/dashboard/specialists/create') ||
            request()->is('dashboard/specialists/create'))
        @include('dashboard.specialists.create')
    @endif

    @isset($specialist->id)
        @if (request()->is(app()->getLocale() . "/dashboard/specialists/$specialist->id/edit") ||
                request()->is("dashboard/specialists/$specialist->id/edit"))
            @include('dashboard.specialists.edit')
        @endif
    @endisset
    @isset($specialist->id)
        @if (request()->is(app()->getLocale() . "/dashboard/specialists/$specialist->id") ||
                request()->is("dashboard/specialists/$specialist->id"))
            @include('dashboard.specialists.show')
        @endif
    @endisset
@endsection
@include('dashboard.layouts.navbar')

@endsection
