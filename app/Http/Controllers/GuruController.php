<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all teachers (guru)
        $guru = Guru::all();

        // Retrieve all classes (kelas)
        $kelas = Kelas::all();

        // Iterate through each teacher and fetch the corresponding nama_kelas
        foreach ($guru as $g) {
            // Fetch the related Kelas model based on the kelas_id of the teacher
            $kelasDetail = Kelas::find($g->kelas_id);

            // Assign the nama_kelas and kompetensi_keahlian to the teacher object
            if ($kelasDetail) {
                $g->nama_kelas = $kelasDetail->nama_kelas;
                $g->kompetensi_keahlian = $kelasDetail->kompetensi_keahlian;
            } else {
                $g->nama_kelas = 'N/A';
                $g->kompetensi_keahlian = ' '; // Set default values if kelas_id is invalid or not found
            }
        }

        // Pass $guru and $kelas variables to the view
        return view('admin.guru.index', compact('guru', 'kelas'));
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
            'nip' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'kelas_id'=>'nullable|exists:kelas,id',
        ]);

        $guru = Guru::create([
            'nip' => $request->input("nip"),
            'nama' => $request->input("nama"),
            'jabatan' => $request->input("jabatan"),
            'no_hp' => $request->input("no_hp"),
            'kelas_id'=> $request->input("kelas_id"),
        ]);

        if ($guru) {
            return redirect()->route('guru.index')->with('success', 'Data guru berhasil disimpan!');
        } else {
            return redirect()->route('guru.index')->with('error', 'Data guru gagal disimpan!');
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
        $guru = Guru::findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
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
            'nip' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'kelas_id'=>'nullable|exists:kelas,id',
        ]);

        $guru = Guru::findOrFail($id);
        $guru->update([
            'nip' => $request->input("nip"),
            'nama' => $request->input("nama"),
            'jabatan' => $request->input("jabatan"),
            'no_hp' => $request->input("no_hp"),
            'kelas_id'=> $request->input("kelas_id"),
            
        ]);

        if ($guru) {
            return redirect()->route('guru.index')->with('update', 'Data guru berhasil diperbarui!');
        } else {
            return redirect()->route('guru.index')->with('error', 'Data guru gagal diperbarui!');
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
        $guru = Guru::findOrFail($id);
        $guru->delete();


        if ($guru) {
            return redirect()->route('guru.index')->with('delete', 'Data guru berhasil dihapus!');
        } else {
            return redirect()->route('guru.index')->with('error', 'Data guru gagal dihapus!');
        }
    }
}
