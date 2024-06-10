@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if ($message = session()->get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if($message = session()->get('update'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if($message = session()->get('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#tambah" class="btn btn-primary btn-sm">Tambah Siswa Kelas</a> -->
            </div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nisn | Nis</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">No Hp</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $no => $s)
                        <tr>
                            <th scope="row">{{ ++$no }}</th>
                            <td>{{ $s->nisn }} | {{ $s->nis }}</td>
                            <td>{{ $s->nama }}</td>
                            <td>{{ $s->kelas->nama_kelas }}</td>
                            <td>{{ $s->no_hp }}</td>
                            <td>
                                
                                <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{$s->id}}" class="btn btn-secondary btn-sm">Edit</a> -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#lihat{{$s->id}}" class="btn btn-warning btn-sm">Lihat</a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#delete{{$s->id}}" class="btn btn-danger btn-sm">Hapus</a><br>
                                <div class="dropdown mt-1">
                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        status
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="{{route('pembayaran.show',$s->id)}}">Riwayat</a></li>
                                        <!-- <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bayar{{$s->id}}">Bayar</a></li> -->
                                        
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </svg>
                                    <div>
                                        Data kelas belum ada
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahDataKelas" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('siswa.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan nama siswa dengan benar">
                        @error('nama')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NISN</label>
                        <input type="number" class="form-control @error('nisn') is-invalid @enderror" name="nisn" placeholder="Masukkan NISN dengan benar">
                        @error('nisn')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="number" class="form-control @error('nis') is-invalid @enderror" name="nis" placeholder="Masukkan NIS dengan benar">
                        @error('nis')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select class="form-select @error('kelas_id') is-invalid @enderror" name='kelas_id' aria-label="Pilih Kelas">
                            <option selected>Open this select menu</option>
                            @foreach($kelas as $k)
                            <option value="{{$k -> id}}">{{$k->nama_kelas}}</option>
                            @endforeach

                        </select>
                        @error('kelas_id')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control @error('kelas_id') is-invalid @enderror" name='alamat' rows="3"></textarea>
                        @error('alamat')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Hp</label>
                        <input type="number" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" placeholder="Masukkan no hp dengan benar">
                        @error('no_hp')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Spp</label>
                        <select class="form-select @error('spp_id') is-invalid @enderror" name='spp_id' aria-label="Pilih masa Spp">
                            <option selected>Open this select menu</option>
                            @foreach($spp as $s)
                            <option value="{{$s -> id}}">{{$s->tahun}}</option>
                            @endforeach
                        </select>
                        @error('spp_id')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit -->
@foreach($siswa as $s)
<div class="modal fade" id="edit{{$s->id}}" tabindex="-1" aria-labelledby="editDataKelas{{$s->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('siswa.update', $s->id) }}" method="POST">
                    @csrf
                    @method ('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{old('nama',$s->nama)}}" placeholder="Masukkan nama siswa dengan benar">
                        @error('nama')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NISN</label>
                        <input type="number" class="form-control @error('nisn') is-invalid @enderror" name="nisn" value="{{old('nisn',$s->nisn)}}" placeholder="Masukkan NISN dengan benar">
                        @error('nisn')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="number" class="form-control @error('nis') is-invalid @enderror" name="nis" value="{{old('nis',$s->nis)}}" placeholder="Masukkan NIS dengan benar">
                        @error('nis')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select class="form-select @error('kelas_id') is-invalid @enderror" name='kelas_id' aria-label="Pilih Kelas">
                            <option selected>{{$s->kelas_id}}</option>
                            @foreach($kelas as $k)
                            <option value="{{$k -> id}}">{{$k->nama_kelas}}</option>
                            @endforeach

                        </select>
                        @error('kelas_id')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control @error('kelas_id') is-invalid @enderror" name='alamat' rows="3">{{$s->alamat}}</textarea>
                        @error('alamat')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Hp</label>
                        <input type="number" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{old('no_hp',$s->no_hp)}}" placeholder="Masukkan no hp dengan benar">
                        @error('no_hp')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Spp</label>
                        <select class="form-select @error('spp_id') is-invalid @enderror" name='spp_id' aria-label="Pilih masa Spp">
                            <option selected>{{$s->spp_id}}</option>
                            @foreach($spp as $spp_option)
                            <option value="{{$spp_option -> id}}">{{$spp_option->tahun}}</option>
                            @endforeach
                        </select>
                        @error('spp_id')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal tampil -->
@foreach($siswa as $s)
<div class="modal fade" id="lihat{{$s->id}}" tabindex="-1" aria-labelledby="editDataKelas{{$s->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>NAMA: {{$s->nama}}</p>
                <p>NISN/NIS: {{$s->nisn}} | {{$s->nis}} </p>
                <p>ALAMAT: {!!$s->alamat!!}</p>
                <p>NO HP: {{$s->no_hp}}</p>
                <p>KELAS: {{$s->kelas->nama_kelas}}</p>
                <p>SPP : {{$s->spp->tahun}}</p>
                <p>NOMINAL SPP : {{$s->spp->nominal}}</p>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal delete -->
@foreach($siswa as $s)
<div class="modal fade" id="delete{{$s->id}}" tabindex="-1" aria-labelledby="editDataKelas{{$s->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin menghapus data {{$s->nama}}?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('siswa.destroy', $s->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal bayar -->
@foreach($siswa as $s)
<div class="modal fade" id="bayar{{$s->id}}" tabindex="-1" aria-labelledby="editDataKelas{{$s->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pembayaran.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{old('nama',$s->nama)}}" placeholder="Masukkan nama siswa dengan benar" readonly>
                        
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control @error('siswa_id') is-invalid @enderror" name="siswa_id" value="{{old('siswa_id',$s->id)}}" placeholder="Masukkan  siswa dengan benar" hidden>
                        @error('siswa_id')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" class="form-control @error('tanggal_bayar') is-invalid @enderror" name="tanggal_bayar"  placeholder="Masukkan tanggal bayar dengan benar">
                        @error('tanggal_bayar')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bulan</label>
                        <select class="form-select @error('bulan') is-invalid @enderror" name='bulan' aria-label="Pilih Bulan">
                            <option selected>Masukkan Bulan Pembayaran</option>
                            <option value="januari">januari</option>
                            <option value="februari">februari</option>
                            <option value="maret">maret</option>
                            <option value="april">april</option>
                            <option value="mei">mei</option>
                            <option value="juni">juni</option>
                            <option value="juli">juli</option>
                            <option value="agustus">agustus</option>
                            <option value="september">september</option>
                            <option value="oktober">oktober</option>
                            <option value="november">november</option>
                            <option value="desember">desember</option>
                        
                        </select>
                        @error('bulan')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    

                    <div class="mb-3">
                        <label class="form-label">No Hp</label>
                        <input type="number" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{old('no_hp',$s->no_hp)}}" placeholder="Masukkan no hp dengan benar">
                        @error('no_hp')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Spp</label>
                        <select class="form-select @error('spp_id') is-invalid @enderror" name='spp_id' aria-label="Pilih masa Spp">
                            <option selected>Yang Harus Dibayarkan</option>
                            @foreach($spp as $spp_option)
                            <option value="{{$spp_option -> id}}">{{$spp_option -> nominal}}</option>
                            @endforeach
                        </select>
                        @error('spp_id')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Administrator</label>
                        <input type="text" class="form-control @error('nama_penginput') is-invalid @enderror" name="nama_penginput" value="{{Auth::user()->name}}" placeholder="Masukkan tanggal bayar dengan benar" readonly>
                        @error('nama_penginput')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endpush