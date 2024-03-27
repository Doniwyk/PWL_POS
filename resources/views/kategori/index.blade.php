@extends ('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kategori')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Kategori</div>
            <div css="card-body">
                {{ $dataTable->table() }}
                <a href="/kategori/create" class="btn btn-outline-primary btn-block" role="button" aria-disabled="true">Tambah Kategori</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts()}}
@endpush