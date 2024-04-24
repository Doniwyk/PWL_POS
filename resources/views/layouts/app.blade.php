@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

@vite('resources/js/app.js')

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')
            
            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
    @yield('content_body')
@stop

{{-- Create a common footer 

{{-- Add common Javascript/Jquery code --}}

@push('js')
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>   
@endpush

{{-- Add common CSS customizations --}}
@stack('scripts')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css"/>
    <style type="text/css">

    /* {{-- You can add AdminLTE customizations here --}} */
    /*
    .card-header {
    border-bottom: none;
    }
    .card-title {
    font-weight: 600;
    }
    */
    </style>
@endpush