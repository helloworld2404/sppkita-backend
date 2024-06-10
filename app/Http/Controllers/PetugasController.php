<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $user = User::paginate(10);
        return view('admin.petugas.index', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->input("name"),
            'email' => $request->input("email"),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input("role"),
        ]);

        if ($user) {
            return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil disimpan!');
        } else {
            return redirect()->route('petugas.index')->with('error', 'Data petugas gagal disimpan!');
        }
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->input("name"),
            'email' => $request->input("email"),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input("role"),
        ]);

        if ($user) {
            return redirect()->route('petugas.index')->with('update', 'Data petugas berhasil diupdate!');
        } else {
            return redirect()->route('petugas.index')->with('error', 'Data petugas gagal disimpan!');
        }
    }

    public function destroy($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();


        if ($petugas) {
            return redirect()->route('petugas.index')->with('delete', 'Data petugas berhasil dihapus!');
        } else {
            return redirect()->route('petugas.index')->with('error', 'Data petugas gagal dihapus!');
        }
    }
}
