@extends('adminlte::page')
{{-- Extend and customize the browser title --}}
@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop
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
{{-- Create a common footer --}}
@section('footer')
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div class="col-md-4 d-flex justify-content-start">
            <span class="text-muted">Sesión</span>
        </div>
        <div class="col-md-4 d-flex justify-content-center">
            <span class="text-muted">© 2023 
                <a href="https://solucionesinformaticasmj.com" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                    Soluciones Informáticas MJ, S.C.A.
                </a>
            </span>
        </div>
        <div class="col-md-4 d-flex justify-content-end">
            <img alt="Version" src="https://img.shields.io/badge/Versión-1.0-blue">
        </div>
    </div>
@stop
{{-- Add common Javascript/Jquery code --}}
@push('js')
<script>
    $(document).ready(function() {
        usersManagement.load();
    });
</script>
@endpush
{{-- Add common CSS customizations --}}
@push('css')
<style type="text/css">
    {{-- You can add AdminLTE customizations here --}}
    /*
    .card-header {
        border-bottom: none;
    }
    .card-title {
        font-weight: 600;
    }
        
    */
    .main-sidebar { background-color: rgb(0, 11, 111) !important }
</style>
@endpush