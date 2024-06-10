<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswakelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Retrieve the current user's ID
        $userId = Auth::id();

        // Retrieve the 'kelas_id' associated with the current user's ID in the 'gurus' table
        $kelasId = Guru::where('id', $userId)->value('kelas_id');

        // Retrieve only the siswa with the same 'kelas_id' as retrieved above
        $siswa = Siswa::where('kelas_id', $kelasId)->with('kelas', 'spp')->paginate();

        // Retrieve all kelas and spp
        $kelas = Kelas::all();
        $spp = Spp::all();

        // Return the filtered siswa data, kelas, and spp as JSON
        return response()->json(compact('siswa', 'kelas', 'spp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:siswas,nisn',
            'nis' => 'required|unique:siswas,nis',
            'nama' => 'required',
            'kelas_id' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'spp_id' => 'required',
        ]);

        $siswa = Siswa::create($request->all());

        if ($siswa) {
            return response()->json(['success' => 'Data siswa berhasil disimpan!'], 201);
        } else {
            return response()->json(['error' => 'Data siswa gagal disimpan!'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return response()->json($siswa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
        $siswa->update($request->all());

        if ($siswa) {
            return response()->json(['success' => 'Data siswa berhasil diperbarui!'], 200);
        } else {
            return response()->json(['error' => 'Data siswa gagal diperbarui!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        
        // Assuming the pembayaran relationship is defined correctly in the Siswa model
        $siswa->pembayaran()->delete();
        $siswa->delete();

        if ($siswa) {
            return response()->json(['success' => 'Data siswa berhasil dihapus!'], 200);
        } else {
            return response()->json(['error' => 'Data siswa gagal dihapus!'], 500);
        }
    }
}
