<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftKaryawan extends Model
{
    use HasFactory;
    protected $table = "ms_shift_jadwal_karyawan";
    protected $primaryKey = "n_shif_jadwal_karyawan_id";
    protected $fillable = [
        "v_shift_jadwal_code", "v_shift_jadwal_desc", "lama_jam_kerja", "keterangan", "jam_masuk", "jam_keluar", "is_lewathari", "is_libur", "color"
    ];
    public $timestamps = false;
}
