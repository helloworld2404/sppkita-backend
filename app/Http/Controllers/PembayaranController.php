<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with('siswa', 'spp');
    
        // Logika filter data berdasarkan request parameter tetap sama
        if ($request->filled('tahun')) {
            $query->whereHas('spp', function ($subQuery) use ($request) {
                $subQuery->where('tahun', $request->tahun);
            });
        }
    
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
    
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'lunas' || $status === 'belum lunas') {
                $query->where('status', $status);
            }
        }
    
        $pembayaran = $query->paginate(30);
    
        // Menentukan tipe respons berdasarkan request
        if ($request->is('api/*')) {
            // Jika permintaan datang dari API, kembalikan respons JSON
            return response()->json($pembayaran);
        } else {
            // Jika permintaan datang dari aplikasi web, kembalikan tampilan HTML
            return view('admin.pembayaran.index', compact('pembayaran'));
        }
    }
    


    public function store(Request $request)
    {
        $this->validate($request,[
            'siswa_id' => 'required',
            'tanggal_bayar' => 'required',
            'bulan' => 'required',
            'spp_id' => 'required',
            'nama_penginput' => 'required',
        ]);

        $pembayaran = Pembayaran::create([
            'siswa_id' => $request->input("siswa_id"),
            'tanggal_bayar' => $request->input("tanggal_bayar"),
            'bulan' => $request->input("bulan"),
            'spp_id' => $request->input("spp_id"),
            'nama_penginput' => $request->input("nama_penginput"),
        ]);

        if ($pembayaran) {
            return response()->json(['success' => 'Data pembayaran berhasil disimpan!'], 201);
        } else {
            return response()->json(['error' => 'Data pembayaran gagal disimpan!'], 500);
        }
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::where('siswa_id', $id)->paginate(10);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function create(){
        $data = Pembayaran::all();
        $pdf = PDF::loadView('admin.pembayaran.invoice', compact('data')); 
        return $pdf->stream();
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = $request->input('status');
        $pembayaran->save();

        return response()->json(['message' => 'Pembayaran status updated successfully'], 200);
    }
}
