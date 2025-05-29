@extends('layouts.master')
{{-- Customize layout sections --}}
@section('subtitle', 'Inicio')
@section('content_header_title', 'Inicio')
@section('content_header_subtitle', '')
{{-- Content body: main page content --}}
@section('content_body')
    <p>{{ __('Inicio') }}</p>
@stop
{{-- Push extra CSS --}}
@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush
{{-- Push extra scripts --}}
@push('js')
    <script> console.log("Hi, We are using the Laravel-AdminLTE package!"); </script>
@endpush