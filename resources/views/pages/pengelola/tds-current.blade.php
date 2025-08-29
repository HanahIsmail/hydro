@extends('layouts.app')

@section('title', 'Data TDS Sekarang')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kondisi Saat Ini</h1>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>TDS</h4>
                        </div>
                        <div class="card-body">
                            <h1>{{ $currentData['tds'] }} ppm</h1>
                            <div class="alert alert-{{ $alert['type'] }}">
                                <i class="fas fa-info-circle"></i> {{ $alert['message'] }}
                            </div>
                            <small>Terakhir diperbarui: {{ $currentData['measured_at']->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Suhu</h4>
                        </div>
                        <div class="card-body">
                            <h1>{{ $currentData['temperature'] }} °C</h1>
                            <div class="alert alert-info">
                                <i class="fas fa-thermometer-half"></i> Suhu saat ini
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kelembapan</h4>
                        </div>
                        <div class="card-body">
                            <h1>{{ $currentData['humidity'] }}%</h1>
                            <div class="alert alert-info">
                                <i class="fas fa-tint"></i> Kelembapan saat ini
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Rentang normal TDS: {{ $tdsMin }}-{{ $tdsMax }} ppm. Segera lakukan penyesuaian nutrisi
                        jika nilai di luar rentang!
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
