<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use App\Models\Role; 
use App\Models\Location; 
use Illuminate\Support\Facades\Hash; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->delete();

        $adminRole = Role::where('nama_peran', 'Admin')->first();
        $pegawaiRole = Role::where('nama_peran', 'Pegawai')->first();
        $lokasiUtama = Location::where('nama_lokasi', 'Kantor Induk UPTD Puskesmas Soropia')->first();

        User::create([
            'nama_lengkap' => 'Admin Puskesmas',
            'nip' => '123456789',
            'email' => 'adminsoropia@gmail.com',
            'password' => Hash::make('password'), 
            'status_kepegawaian' => 'PNS',
            'jabatan' => 'Administrator',
            'penempatan_id' => $lokasiUtama->id,
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'nama_lengkap' => 'Pegawai Contoh',
            'nip' => '987654321',
            'email' => 'pegawai@soropia.com',
            'password' => Hash::make('password'), 
            'status_kepegawaian' => 'P3K',
            'jabatan' => 'Perawat',
            'penempatan_id' => $lokasiUtama->id,
            'role_id' => $pegawaiRole->id,
        ]);
    }
}