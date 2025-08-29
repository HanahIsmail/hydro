@extends('layouts.app')

@section('title', 'Riwayat Per Jam')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Riwayat Per Jam TDS</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Riwayat Per Jam</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Filter Tanggal</h4>
                        <div class="card-header-action">
                            <form id="filterForm">
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" name="date"
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
                        <canvas id="hourlyChart" height="100"></canvas>

                        <div class="mt-5">
                            <h5>Detail Pembacaan</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>TDS</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hourlyData as $data)
                                            <tr>
                                                <td>{{ $data->measured_at->format('H:i') }}</td>
                                                <td>{{ $data->tds }} ppm</td>
                                                <td>
                                                    <span class="badge badge-{{ $data->status }}">
                                                        {{ $data->status_text }}
                                                    </span>
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
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        // Chart
        new Chart(document.getElementById('hourlyChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Nilai TDS',
                    data: @json($chartData['values']),
                    borderColor: '#6777ef',
                    pointBackgroundColor: function(context) {
                        const value = context.dataset.data[context.dataIndex];
                        return (value < 1000 || value > 1200) ? '#fc544b' : '#6777ef';
                    },
                    tension: 0.1
                }, {
                    type: 'line',
                    label: 'Batas Normal Bawah',
                    data: Array(@json($chartData['labels']).length).fill({{ $tdsMin }}),
                    borderColor: '#47c363',
                    borderDash: [5, 5],
                    borderWidth: 1,
                    pointRadius: 0
                }, {
                    type: 'line',
                    label: 'Batas Normal Atas',
                    data: Array(@json($chartData['labels']).length).fill({{ $tdsMax }}),
                    borderColor: '#47c363',
                    borderDash: [5, 5],
                    borderWidth: 1,
                    pointRadius: 0
                }]
            },
            options: {
                scales: {
                    y: {
                        suggestedMin: {{ $tdsMin - 200 }},
                        suggestedMax: {{ $tdsMax + 200 }},
                        title: {
                            display: true,
                            text: 'Nilai TDS (ppm)'
                        }
                    }
                }
            }
        });

        // Datepicker
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxDate: new Date()
        });
    </script>
@endpush
