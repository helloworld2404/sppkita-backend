<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Menentukan tabel secara eksplisit (opsional)
    protected $table = 'siswas';

    // Definisi fillable properties
    protected $fillable = [
        'nisn', 'nis', 'nama', 'kelas_id', 'alamat', 'no_hp', 'spp_id'
    ];

    // Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi ke model Spp
    public function spp()
    {
        return $this->belongsTo(Spp::class, 'spp_id');
    }

    // Relasi ke model Pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'siswa_id');
    }
}
    