@php
use App\Models\TDSData;
use App\Models\User
@endphp

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
                    <div class="card-icon bg-danger">
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
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Bulan Ini</h4>
                        </div>
                        <div class="card-body">
                            {{ TDSData::whereMonth('measured_at', now()->month)->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                        <h4>Daftar Pengelola</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($managers as $manager)
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
    // Grafik tahunan
    var annualChart = new Chart(document.getElementById('annualChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Rata-rata TDS',
                data: {!! json_encode($chartData['averages']) !!},
                backgroundColor: {!! json_encode($chartData['colors']) !!},
                borderColor: '#6777ef',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false,
                    suggestedMin: 800,
                    suggestedMax: 1400
                }
            }
        }
    });
</script>
@endpush
