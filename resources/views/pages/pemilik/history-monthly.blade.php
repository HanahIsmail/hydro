@php
use Carbon\Carbon;
@endphp
@extends('layouts.app')

@section('title', 'Riwayat Bulanan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Riwayat Bulanan TDS</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Riwayat Bulanan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Filter Data</h4>
                        <div class="card-header-action">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
                                    Tahun {{ $selectedYear }} <i class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach ($availableYears as $year)
                                        <a href="?year={{ $year }}" class="dropdown-item">{{ $year }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart" height="150"></canvas>

                        <div class="mt-5">
                            <h5>Rekap Data Bulanan</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Rata-rata</th>
                                            <th>Minimum</th>
                                            <th>Maksimum</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($monthlyData as $month => $data)
                                            @php
                                                $avg = $data->avg('tds');
                                            @endphp
                                            <tr>
                                                <td>{{ Carbon::parse($month)->isoFormat('MMMM YYYY') }}</td>
                                                <td>{{ round($avg, 2) }}</td>
                                                <td>{{ $data->min('tds') }}</td>
                                                <td>{{ $data->max('tds') }}</td>
                                                <td>
                                                    @if ($avg < 1000)
                                                        <span class="badge badge-danger">Rendah</span>
                                                    @elseif($avg > 1200)
                                                        <span class="badge badge-danger">Tinggi</span>
                                                    @else
                                                        <span class="badge badge-success">Normal</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
        new Chart(document.getElementById('monthlyChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Rata-rata TDS',
                    data: @json($chartData['averages']),
                    backgroundColor: @json(array_map(function ($s) {
                            return $s === 'danger' ? '#fc544b' : '#6777ef';
                        }, $chartData['statuses'])),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        suggestedMin: 800,
                        suggestedMax: 1400,
                        title: {
                            display: true,
                            text: 'Nilai TDS (ppm)'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            footer: (items) => {
                                const {
                                    dataIndex
                                } = items[0];
                                return `Min: ${@json($chartData['minimums'])[dataIndex]}\nMax: ${@json($chartData['maximums'])[dataIndex]}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
