@extends('layout.main')

@section('title', 'Dashboard')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </section>
    @if (Auth::user()->role == 'User Entry')
        @include('pages.dashboard.badanUsaha')
    @else
        @include('pages.dashboard.approve')
    @endif
</div>
@endsection

@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function() {
            var startDateInput = document.getElementById("start_date");
            var endDateInput = document.getElementById("end_date");

            // Fungsi untuk menghitung tanggal akhir berdasarkan tanggal awal
            function updateEndDate() {
                var startDate = new Date(startDateInput.value);
                var endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + 14);

                // Format tanggal ke dalam "YYYY-MM-DD" untuk input
                var formattedEndDate = endDate.toISOString().split('T')[0];
                endDateInput.value = formattedEndDate;
            }

            // Panggil fungsi saat tanggal awal berubah
            startDateInput.addEventListener("change", updateEndDate);

            // Inisialisasi tanggal awal dan tanggal akhir saat halaman dimuat
            updateEndDate();
        });
</script>

@endpush