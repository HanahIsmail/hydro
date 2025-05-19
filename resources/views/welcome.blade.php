@extends('layouts.app-home')

@section('title', 'Welcome')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Selamat Datang</h1>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>TDS</h4>
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
                            <i class="fas fa-cloud"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kelembapan</h4>
                            </div>
                            <div class="card-body">
                                {{ $currentData['humidity'] }} %
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lokasi Greenhouse</h4>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset('img/greenhouse.jpeg') }}" class="img-fluid rounded"
                                style="max-height: 400px;">
                            <div class="mt-3">
                                <h5>{{ $location['name'] }}</h5>
                                <p>{{ $location['address'] }}</p>
                                <a href="{{ $location['maps_url'] }}" target="_blank" class="btn btn-primary">
                                    <i class="fas fa-map-marker-alt"></i> Lihat di Peta
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
