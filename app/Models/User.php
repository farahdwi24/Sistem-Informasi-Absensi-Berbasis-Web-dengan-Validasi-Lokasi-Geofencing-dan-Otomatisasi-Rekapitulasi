<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Notifications\NotifikasiResetPassword;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lengkap',
        'nip',
        'email',
        'password',
        'status_kepegawaian',
        'jabatan',
        'foto',
        'penempatan',
        'role_id',
        'jenis_kelamin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function attendances(): HasMany
    {
    
        return $this->hasMany(Attendance::class, 'pegawai_id');
    }


    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new NotifikasiResetPassword($token, $this->email));
    }
}
