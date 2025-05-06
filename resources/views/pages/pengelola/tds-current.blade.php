@extends('layouts.app')

@section('title', 'Data TDS Sekarang')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data TDS Sekarang</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @if($currentTDS)
                        <div class="alert @if($currentTDS->value < 1000 || $currentTDS->value > 1200) alert-danger @else alert-success @endif">
                            <h4>Nilai TDS: {{ $currentTDS->value }}</h4>
                            <p>Terakhir diperbarui: {{ $currentTDS->created_at }}</p>

                            @if($currentTDS->value < 1000)
                                <p><strong>Peringatan!</strong> Nilai TDS terlalu rendah (minimal 1000)</p>
                            @elseif($currentTDS->value > 1200)
                                <p><strong>Peringatan!</strong> Nilai TDS terlalu tinggi (maksimal 1200)</p>
                            @else
                                <p>Nilai TDS dalam rentang normal (1000-1200)</p>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>Tidak ada data TDS tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
