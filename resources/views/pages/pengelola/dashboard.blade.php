@extends('layouts.app')

@section('title', 'Dashboard Pengelola')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard Pengelola</h1>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>TDS Terkini</h4>
                            </div>
                            <div class="card-body">
                                {{ $currentTDS->value ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Status Nutrisi</h4>
                            </div>
                            <div class="card-body">
                                @if($currentTDS)
                                    @if($currentTDS->value < 1000)
                                        Terlalu Rendah
                                    @elseif($currentTDS->value > 1200)
                                        Terlalu Tinggi
                                    @else
                                        Normal
                                    @endif
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik TDS 24 Jam Terakhir</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="hourlyChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Peringatan</h4>
                        </div>
                        <div class="card-body">
                            @if($currentTDS && ($currentTDS->value < 1000 || $currentTDS->value > 1200))
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle"></i> Nilai TDS saat ini
                                    ({{ $currentTDS->value }}) berada di luar rentang normal (1000-1200)!
                                </div>
                            @else
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> Nilai TDS dalam rentang normal.
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
                            <a href="{{ route('tds.current') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-tint"></i> Lihat Data TDS
                            </a>
                            <a href="{{ route('hourly.history') }}" class="btn btn-info btn-block mt-2">
                                <i class="fas fa-history"></i> Riwayat Per Jam
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        var hourlyChart = new Chart(document.getElementById('hourlyChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($hourlyChart['labels']) !!},
                datasets: [{
                    label: 'Nilai TDS',
                    data: {!! json_encode($hourlyChart['values']) !!},
                    borderColor: '#6777ef',
                    backgroundColor: 'rgba(103, 119, 239, 0.2)',
                    pointBackgroundColor: '#fff',
                    pointRadius: 3,
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        suggestedMin: 800,
                        suggestedMax: 1400,
                        ticks: {
                            stepSize: 100
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'TDS: ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
