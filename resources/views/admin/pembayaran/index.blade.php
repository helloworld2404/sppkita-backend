@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mt-1 mb-1">
                <a href="{{ route('pembayaran.create') }}" class="btn btn-danger btn-sm">Eksport</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <marquee behavior="left" direction="lef">Rekapitulasi Pembayaran</marquee>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form action="{{ route('pembayaran.index') }}" method="GET">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="text" class="form-control" id="tahun" name="tahun" value="{{ request()->input('tahun') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="bulan" class="form-label">Bulan</label>
                                <input type="text" class="form-control" id="bulan" name="bulan" value="{{ request()->input('bulan') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua</option>
                                    <option value="lunas" @if(request()->input('status') == 'lunas') selected @endif>Lunas</option>
                                    <option value="belum lunas" @if(request()->input('status') == 'belum lunas') selected @endif>Belum Lunas</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-4">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Tanggal Bayar</th>
                                <th scope="col">Bulan</th>
                                <th scope="col">Tahun || Nominal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayaran as $no => $p)
                            <tr>
                                <th scope="row">{{ ++$no }}</th>
                                <td>{{ $p->siswa->nama }}</td>
                                <td>{{ $p->tanggal_bayar }}</td>
                                <td>{{ $p->bulan }}</td>
                                <td>{{ $p->spp->tahun }}</td>
                                <td>{{ $p->status }}</td>
                                <td>{{ $p->nama_penginput }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                        </svg>
                                        <div>
                                            Data pembayaran belum ada
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$pembayaran->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
