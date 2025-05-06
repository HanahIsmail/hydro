@extends('layouts.auth')

@section('title', 'Login')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')
    <div class="card card-primary text-center p-4">
        <div class="mb-3">
            <!-- Logo -->
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height: 80px;">
        </div>
        <h5 class="mb-1 font-weight-bold">Selamat datang di</h5>
        <h6 class="mb-4 text-muted">Sistem Pemantauan Nutrisi</h6>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group text-left">
                    <label for="email">Email</label>
                    <input id="email" type="text"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" tabindex="1" autofocus placeholder="Masukan email anda">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group text-left">
                    <label for="password" class="control-label">Password</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" tabindex="2" placeholder="Masukan password anda">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <!-- Page Specific JS File -->
@endpush
