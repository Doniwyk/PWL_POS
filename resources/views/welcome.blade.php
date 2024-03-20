@extends('layout.app')

{{-- Customize layout sections  --}}
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome')

{{-- Content body: main page content --}}
@section('content_body')
    <p>Welcome to this beatiful admin panel.</p>
@stop

{{-- Push extra CSS --}}
@push('css')
{{-- Add here extra stylesheets --}}
@endpush

{{-- Push extra JS --}}
@push('js')
    <script> console.log("Hi, I'm using the laravel-AdminLTE package!"); </script>
@endpush