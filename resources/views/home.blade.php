@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @php
                    $userRole = Auth::user()->role;
                    @endphp

                    @if ($userRole == 1)
                    Selamat datang admin
                    @elseif ($userRole == 2)
                    Selamat datang petugas
                    @elseif ($userRole == 3)
                    Selamat datang siswa & orang tua
                    @elseif ($userRole == 4)
                    Selamat datang wali kelas
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection