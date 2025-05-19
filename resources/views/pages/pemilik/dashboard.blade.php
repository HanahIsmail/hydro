@extends('layouts.app')

@section('title', 'Dashboard Pemilik')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/chart.js/dist/Chart.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard Pemilik</h1>
            </div>

            <!-- Statistik Utama -->
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pengelola</h4>
                            </div>
                            <div class="card-body">
                                {{ $managers->count() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
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
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
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

            <!-- Grafik dan Daftar Pengelola -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Tahunan TDS</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="annualChart" height="180"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Sensor Terkini</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    TDS
                                    <span
                                        class="badge badge-{{ $currentData['tds'] < 1000 || $currentData['tds'] > 1200 ? 'danger' : 'success' }}">
                                        {{ $currentData['tds'] }} ppm
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    Terakhir Update:
                                    {{ $currentData['measured_at']->diffForHumans() }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Daftar Pengelola</h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @foreach ($managers as $manager)
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $manager->name }}</h6>
                                            <small>{{ $manager->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1">{{ $manager->email }}</p>
                                    </a>
                                @endforeach
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
        // Grafik Tahunan
        new Chart(document.getElementById('annualChart'), {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Rata-rata TDS Bulanan',
                    data: @json($chartData['averages']),
                    backgroundColor: @json(array_map(function ($s) {
                            return $s === 'danger' ? '#fc544b' : '#6777ef';
                        }, $chartData['statuses'])),
                    borderWidth: 1
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
