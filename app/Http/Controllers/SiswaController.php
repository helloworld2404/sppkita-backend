<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $siswa = Siswa::with('kelas','spp')->paginate();
        $kelas= Kelas::all();
        $spp= Spp::all();

        foreach ($siswa as $s) {
            // Fetch the related Kelas model based on the kelas_id of the teacher
            $kelasDetail = Kelas::find($s->kelas_id);

            // Assign the nama_kelas and kompetensi_keahlian to the teacher object
            if ($kelasDetail) {
                $s->nama_kelas = $kelasDetail->nama_kelas;
                $s->kompetensi_keahlian = $kelasDetail->kompetensi_keahlian;
            } else {
                $s->nama_kelas = 'N/A';
                $s->kompetensi_keahlian = ' '; // Set default values if kelas_id is invalid or not found
            }
        }

        // Menentukan tipe respons berdasarkan request
        if ($request->is('api/*')) {
            // Jika permintaan datang dari API, kembalikan respons JSON
            return response()->json($siswa);
        } else {
            // Jika permintaan datang dari aplikasi web, kembalikan tampilan HTML
            return view('admin.siswa.index', compact('siswa','kelas','spp'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required |unique:siswas,nisn',
            'nis' => 'required |unique:siswas,nis',
            'nama' => 'required',
            'kelas_id' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'spp_id' => 'required',
        ]);

        $siswa = Siswa::create([
            'nisn' => $request->input("nisn"),
            'nis' => $request->input("nis"),
            'nama' => $request->input("nama"),
            'kelas_id' => $request->input("kelas_id"),
            'alamat' => $request->input("alamat"),
            'no_hp' => $request->input("no_hp"),
            'spp_id' => $request->input("spp_id"),
        ]);

        if ($siswa) {
            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil disimpan!');
        } else {
            return redirect()->route('siswa.index')->with('error', 'Data siswa gagal disimpan!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = Siswa::findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nisn' => 'required',
            'nis' => 'required',
            'nama' => 'required',
            'kelas_id' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'spp_id' => 'required',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nisn' => $request->input("nisn"),
            'nis' => $request->input("nis"),
            'nama' => $request->input("nama"),
            'kelas_id' => $request->input("kelas_id"),
            'alamat' => $request->input("alamat"),
            'no_hp' => $request->input("no_hp"),
            'spp_id' => $request->input("spp_id"),
        ]);

        if ($siswa) {
            return redirect()->route('siswa.index')->with('update', 'Data siswa berhasil diperbarui!');
        } else {
            return redirect()->route('siswa.index')->with('error', 'Data siswa gagal diperbarui!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->pembayaran()->delete();
        $siswa->delete();


        if ($siswa) {
            return redirect()->route('siswa.index')->with('delete', 'Data siswa berhasil dihapus!');
        } else {
            return redirect()->route('siswa.index')->with('error', 'Data siswa gagal dihapus!');
        }
    }
}

