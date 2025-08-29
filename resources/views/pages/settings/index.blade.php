@extends('layouts.app')

@section('title', 'Pengaturan TDS')

@push('style')
    <style>
        .settings-card {
            transition: all 0.3s ease;
        }

        .edit-form {
            display: none;
        }

        .current-values {
            display: block;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pengaturan Rentang TDS</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Pengaturan TDS</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card settings-card">
                            <div class="card-header">
                                <h4>Rentang Nilai TDS Saat Ini</h4>
                            </div>
                            <div class="card-body">
                                <!-- Tampilkan nilai saat ini -->
                                <div class="current-values" id="currentValues">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nilai Minimum</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="{{ $tdsMin }} ppm" disabled>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-arrow-down"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nilai Maksimum</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="{{ $tdsMax }} ppm" disabled>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-arrow-up"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 text-center">
                                            <button class="btn btn-primary" id="editButton">
                                                <i class="fas fa-edit"></i> Ubah Nilai
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form untuk mengubah nilai -->
                                <div class="edit-form" id="editForm">
                                    <form action="{{ route('settings.update') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tds_min">TDS Minimal Baru (ppm)</label>
                                                    <input type="number" class="form-control" id="tds_min" name="tds_min"
                                                        value="{{ old('tds_min', $tdsMin) }}" required min="0"
                                                        step="1">
                                                    @error('tds_min')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tds_max">TDS Maksimal Baru (ppm)</label>
                                                    <input type="number" class="form-control" id="tds_max" name="tds_max"
                                                        value="{{ old('tds_max', $tdsMax) }}" required min="0"
                                                        step="1">
                                                    @error('tds_max')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-12 text-center">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-check"></i> Simpan Perubahan
                                                </button>
                                                <button type="button" class="btn btn-secondary" id="cancelButton">
                                                    <i class="fas fa-times"></i> Batal
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi tentang TDS -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4>Informasi TDS</h4>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h6>Pentingnya Mengatur Rentang TDS</h6>
                                    <p class="mb-0">
                                        TDS (Total Dissolved Solids) mengukur konsentrasi nutrisi dalam air.
                                        Rentang yang tepat sangat penting untuk pertumbuhan tanaman yang optimal:
                                    </p>
                                    <ul class="mt-2">
                                        <li>Nilai terlalu rendah: Tanaman kekurangan nutrisi</li>
                                        <li>Nilai terlalu tinggi: Dapat merusak akar tanaman</li>
                                    </ul>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.getElementById('editButton');
            const cancelButton = document.getElementById('cancelButton');
            const currentValues = document.getElementById('currentValues');
            const editForm = document.getElementById('editForm');

            // Tampilkan form edit saat tombol ubah diklik
            editButton.addEventListener('click', function() {
                currentValues.style.display = 'none';
                editForm.style.display = 'block';
            });

            // Sembunyikan form edit saat tombol batal diklik
            cancelButton.addEventListener('click', function() {
                editForm.style.display = 'none';
                currentValues.style.display = 'block';
            });

            // Validasi form
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const tdsMin = parseFloat(document.getElementById('tds_min').value);
                const tdsMax = parseFloat(document.getElementById('tds_max').value);

                if (tdsMin >= tdsMax) {
                    e.preventDefault();
                    alert('Nilai maksimal harus lebih besar dari nilai minimal!');
                    return false;
                }
            });
        });
    </script>
@endpush
