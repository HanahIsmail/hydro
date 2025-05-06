@extends('layouts.app')

@section('title', 'Grafik Per Jam TDS')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Grafik Per Jam TDS</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Grafik Per Jam</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data TDS 24 Jam Terakhir</h4>
                                <div class="card-header-action">
                                    <form id="filter-form" method="GET">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control datepicker"
                                                name="date"
                                                value="{{ $selectedDate->format('Y-m-d') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-filter"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="hourlyChart" height="300"></canvas>

                                <div class="mt-5">
                                    <h5>Detail Pembacaan</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Waktu</th>
                                                    <th>Nilai TDS</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($hourlyData as $data)
                                                <tr>
                                                    <td>{{ $data->measured_at->format('H:i') }}</td>
                                                    <td>{{ $data->value }}</td>
                                                    <td>
                                                        @if($data->value < 1000)
                                                            <span class="badge badge-danger">Rendah</span>
                                                        @elseif($data->value > 1200)
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
        var hourlyChart = new Chart(document.getElementById('hourlyChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['labels']) !!},
                datasets: [{
                    label: 'Nilai TDS',
                    data: {!! json_encode($chartData['values']) !!},
                    borderColor: '#6777ef',
                    backgroundColor: 'rgba(103, 119, 239, 0.1)',
                    pointBackgroundColor: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        return value < 1000 || value > 1200 ? '#fc544b' : '#6777ef';
                    },
                    pointRadius: 4,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.1
                },
                {
                    label: 'Batas Normal',
                    data: Array({!! json_encode($chartData['labels']) !!}.length).fill(1000),
                    borderColor: '#47c363',
                    borderWidth: 1,
                    borderDash: [5, 5],
                    pointRadius: 0
                },
                {
                    label: 'Batas Normal',
                    data: Array({!! json_encode($chartData['labels']) !!}.length).fill(1200),
                    borderColor: '#47c363',
                    borderWidth: 1,
                    borderDash: [5, 5],
                    pointRadius: 0
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
                    },
                    annotation: {
                        annotations: {
                            line1: {
                                type: 'line',
                                yMin: 1000,
                                yMax: 1000,
                                borderColor: 'rgb(75, 192, 192)',
                                borderWidth: 2,
                                borderDash: [5, 5],
                            },
                            line2: {
                                type: 'line',
                                yMin: 1200,
                                yMax: 1200,
                                borderColor: 'rgb(75, 192, 192)',
                                borderWidth: 2,
                                borderDash: [5, 5],
                            }
                        }
                    }
                }
            }
        });

        // Datepicker initialization
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxDate: new Date()
        });
    </script>
@endpush
