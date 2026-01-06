<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lokasi',
        'latitude',
        'longitude',
        'radius_meter',
    ];
    public function pegawaiYangDitempatkan(): HasMany
    {
        return $this->hasMany(User::class, 'penempatan_id');
    }

    public function absensiDiLokasiIni(): HasMany
    {
        return $this->hasMany(Attendance::class, 'lokasi_id');
    }
}
