<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.kelas.index', compact('kelas'));
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
            'nama_kelas' => 'required',
            'kompetensi_keahlian' => 'required'
        ]);

        $kelas = Kelas::create([
            'nama_kelas' => $request->input("nama_kelas"),
            'kompetensi_keahlian' => $request->input("kompetensi_keahlian"),
        ]);

        if ($kelas) {
            return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil disimpan!');
        } else {
            return redirect()->route('kelas.index')->with('error', 'Data kelas gagal disimpan!');
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
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas'));
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
            'nama_kelas' => 'required',
            'kompetensi_keahlian' => 'required'
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->input('nama_kelas'),
            'kompetensi_keahlian' => $request->input('kompetensi_keahlian')
        ]);

        if ($kelas) {
            return redirect()->route('kelas.index')->with('update', 'Data kelas berhasil diperbarui!');
        } else {
            return redirect()->route('kelas.index')->with('error', 'Data kelas gagal diperbarui!');
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
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();


        if ($kelas) {
            return redirect()->route('kelas.index')->with('delete', 'Data kelas berhasil dihapus!');
        } else {
            return redirect()->route('kelas.index')->with('error', 'Data kelas gagal dihapus!');
        }
    }
}
