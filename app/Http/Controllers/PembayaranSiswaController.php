<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;

class PembayaranSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Get the current user's ID
        $userId = Auth::id();

        // Start building query to retrieve pembayaran records
        $query = Pembayaran::with('siswa', 'spp')
            ->where('siswa_id', $userId);

        // Apply filtering by 'tahun' if provided in the request
        if ($request->filled('tahun')) {
            $query->whereHas('spp', function ($subQuery) use ($request) {
                $subQuery->where('tahun', $request->tahun);
            });
        }

        // Apply filtering by 'bulan' if provided in the request
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        // Apply filtering by 'status' if provided in the request
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'lunas' || $status === 'belum lunas') {
                $query->where('status', $status);
            }
        }

        // Get the paginated pembayaran records based on the filtered or unfiltered query
        $pembayaran = $query->paginate(10);

        return response()->json($pembayaran);

        return view('admin.pembayaran_siswa.index', compact('pembayaran'));
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
        // Get the current user's ID
        $userId = Auth::id();

        // Retrieve the current user's kelas_id from the gurus table
        $kelasId = Guru::where('id', $userId)->value('kelas_id');

        // Get the siswa with the specified ID
        $siswa = Siswa::findOrFail($id);

        // Check if the siswa has the same kelas_id as the current user
        if ($siswa->kelas_id == $kelasId) {
            // Get the pembayaran records associated with the siswa
            $pembayaran = Pembayaran::where('siswa_id', $id)->paginate(10);
            return response()->json($pembayaran);
            return view('admin.pembayaran_siswa.show', compact('pembayaran'));
        } else {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
    }

    public function create()
    {
        // Get the current user's ID
        $userId = Auth::id();

        // Get the pembayaran records associated with the current user's siswa_id
        $data = Pembayaran::whereHas('siswa', function ($query) use ($userId) {
            $query->where('siswa_id', $userId);
        })->get();

        // Load the view with the filtered data and create the PDF
        $pdf = PDF::loadView('admin.pembayaran_siswa.invoice', compact('data'));
        return $pdf->stream();
    }

}
