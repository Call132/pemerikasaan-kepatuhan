@extends('layout.main')

@section('title', 'Dashboard')

@push('style')
    <!-- Tambahkan tautan stylesheet yang diperlukan di sini -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <div class="row">
                <!-- Tambahkan konten dashboard Anda di sini -->
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Informasi Utama</h4>
                        </div>
                        <div class="card-body">
                            <!-- Tambahkan konten informasi utama di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- Tambahkan tautan skrip JavaScript yang diperlukan di sini -->
@endpush
