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
                <a href="#" data-bs-toggle="modal" data-bs-target="#tambah" class="btn btn-primary btn-sm">Tambah data</a>
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
                            <th scope="col">Nip</th>
                            <th scope="col">Nama Guru</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">No Hp</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guru as $no => $g)
                        <tr>
                            <th scope="row">{{ ++$no }}</th>
                            <td>{{ $g->nip }}</td>
                            <td>{{ $g->nama }}</td>
                            <td>{{ $g->jabatan }}</td>
                            <td>{{ $g->no_hp }}</td>
                            <td>{{ $g->nama_kelas }} - {{ $g->kompetensi_keahlian }}</td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{$g->id}}" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#delete{{$g->id}}" class="btn btn-danger btn-sm">Hapus</a>
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
                                        Data guru belum ada
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
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahDataGuru" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('guru.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nip</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" placeholder="Masukkan nip  dengan benar">
                        @error('nip')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama </label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan nama  dengan benar">
                        @error('nama')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" placeholder="Masukkan jabatan dengan benar">
                        @error('jabatan')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Hp</label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" placeholder="Masukkan nomor telepon dengan benar">
                        @error('no_hp')
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
                            <option value="{{$k -> id}}">
                                {{ $k->nama_kelas }} - {{ $k->kompetensi_keahlian }}
                            </option>
                            @endforeach

                        </select>
                        @error('kelas_id')
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
@foreach($guru as $g)
<div class="modal fade" id="edit{{$g->id}}" tabindex="-1" aria-labelledby="editDataGuru{{$g->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('guru.update', $g->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nip</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ $g->nip }}" placeholder="Masukkan nip dengan benar">
                        @error('nip')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $g->nama }}" placeholder="Masukkan nama dengan benar">
                        @error('nama')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" value="{{ $g->jabatan }}" placeholder="Masukkan nama jabatan dengan benar">
                        @error('jabatan')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Hp</label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ $g->no_hp }}" placeholder="Masukkan no telepon dengan benar">
                        @error('no_hp')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select class="form-select @error('kelas_id') is-invalid @enderror" name='kelas_id' aria-label="Pilih Kelas">
                            <option value="{{ $g->kelas_id }}" selected>
                                {{ $g->nama_kelas }} - {{ $g->kompetensi_keahlian }}
                            </option>
                            @foreach($kelas as $k)
                                @if($k->id != $g->kelas_id) <!-- Exclude the currently selected class -->
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama_kelas }} - {{ $k->kompetensi_keahlian }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('kelas_id')
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

<!-- Modal delete -->
@foreach($guru as $g)
<div class="modal fade" id="delete{{$g->id}}" tabindex="-1" aria-labelledby="editDataGuru{{$g->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p> Apakah anda yakin menghapus data {{$g->nama}}</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                <form id="deleteForm{{$g->id}}" action="{{route('guru.destroy', $g->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">HAPUS</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

@endforeach

@endpush
