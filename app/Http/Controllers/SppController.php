<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class SppController extends Controller
{
    public function index(Request $request)
    {
        $spp = Spp::all();

        if (FacadesRequest::is('api/*')) {
            return response()->json($spp, 200);
        } else {
            return view('admin.spp.index', compact('spp'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'nominal' => 'required'
        ]);

        try {
            $spp = Spp::create([
                'tahun' => $request->input("tahun"),
                'nominal' => $request->input("nominal"),
            ]);

            return response()->json(['success' => 'Data SPP berhasil disimpan!', 'data' => $spp], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data SPP gagal disimpan! ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required',
            'nominal' => 'required'
        ]);

        try {
            $spp = Spp::findOrFail($id);
            $spp->update([
                'tahun' => $request->input("tahun"),
                'nominal' => $request->input("nominal"),
            ]);

            return response()->json(['success' => 'Data SPP berhasil diupdate!', 'data' => $spp], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data SPP gagal diupdate! ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $spp = Spp::findOrFail($id);
            $spp->delete();

            return response()->json(['success' => 'Data SPP berhasil dihapus!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data SPP gagal dihapus! ' . $e->getMessage()], 500);
        }
    }
}
