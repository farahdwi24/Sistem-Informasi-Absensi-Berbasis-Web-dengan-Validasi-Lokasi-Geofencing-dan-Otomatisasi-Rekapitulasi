<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pegawai_id',
        'lokasi_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status_kehadiran',
        'status_persetujuan',
        'keterangan',
        'file_lampiran',
    ];
    protected $casts = [
        'tanggal' => 'datetime',
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime',
    ];


    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'lokasi_id');
    }
}
