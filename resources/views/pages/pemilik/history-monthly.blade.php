@extends('layouts.app')

@section('title', 'Grafik Bulanan TDS')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Grafik Bulanan TDS</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Grafik Bulanan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data TDS Per Bulan</h4>
                                <div class="card-header-action">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-primary"
                                            data-toggle="dropdown">Filter Tahun</a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @foreach($availableYears as $year)
                                                <a href="?year={{ $year }}"
                                                    class="dropdown-item">{{ $year }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="monthlyChart" height="300"></canvas>

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
                                                @foreach($monthlyData as $month => $data)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($month)->isoFormat('MMMM YYYY') }}</td>
                                                    <td>{{ round($data->avg('value'), 2) }}</td>
                                                    <td>{{ $data->min('value') }}</td>
                                                    <td>{{ $data->max('value') }}</td>
                                                    <td>
                                                        @php
                                                            $avg = $data->avg('value');
                                                        @endphp
                                                        @if($avg < 1000)
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
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        var monthlyChart = new Chart(document.getElementById('monthlyChart').getContext('2d'), {
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
                                return [
                                    'Rata-rata: ' + context.raw,
                                    'Min: ' + {!! json_encode($chartData['minimums']) !!}[context.dataIndex],
                                    'Max: ' + {!! json_encode($chartData['maximums']) !!}[context.dataIndex]
                                ];
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
