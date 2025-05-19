@extends('layouts.app')

@section('title', 'Dashboard Pengelola')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/chart.js/dist/Chart.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard Pengelola</h1>
            </div>

            <!-- Statistik Utama -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>TDS Terkini</h4>
                            </div>
                            <div class="card-body">
                                {{ $currentData['tds'] }} ppm
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-thermometer-half"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Temperatur</h4>
                            </div>
                            <div class="card-body">
                                {{ $currentData['temperature'] }} °C
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kelembapan</h4>
                            </div>
                            <div class="card-body">
                                {{ $currentData['humidity'] }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik dan Peringatan -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik 24 Jam Terakhir</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="hourlyChart" height="120"></canvas>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Status Sistem</h4>
                        </div>
                        <div class="card-body">
                            @if ($currentData['tds'] < 1000)
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Nilai TDS terlalu rendah! Tambahkan nutrisi.
                                </div>
                            @elseif($currentData['tds'] > 1200)
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Nilai TDS terlalu tinggi! Kurangi nutrisi.
                                </div>
                            @else
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i>
                                    Sistem berjalan normal
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Aksi Cepat</h4>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('tds.current') }}" class="btn btn-icon icon-left btn-primary btn-block">
                                <i class="fas fa-tint"></i> Lihat Detail TDS
                            </a>

                            <a href="{{ route('history.hourly') }}" class="btn btn-icon icon-left btn-info btn-block mt-3">
                                <i class="fas fa-history"></i> Riwayat Per Jam
                            </a>

                            <div class="mt-4">
                                <h6>Update Terakhir:</h6>
                                <p class="text-muted">
                                    {{ $currentData['measured_at']->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script>
        // Grafik Per Jam
        new Chart(document.getElementById('hourlyChart'), {
            type: 'line',
            data: {
                labels: @json($hourlyChart['labels']),
                datasets: [{
                    label: 'Nilai TDS',
                    data: @json($hourlyChart['values']),
                    borderColor: '#6777ef',
                    backgroundColor: 'rgba(103, 119, 239, 0.2)',
                    fill: true,
                    tension: 0.1,
                    pointBackgroundColor: function(context) {
                        const value = context.dataset.data[context.dataIndex];
                        return (value < 1000 || value > 1200) ? '#fc544b' : '#6777ef';
                    }
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        suggestedMin: 800,
                        suggestedMax: 1400,
                        title: {
                            display: true,
                            text: 'Nilai TDS (ppm)'
                        }
                    }
                }
            }
        });
    </script>
@endpush
