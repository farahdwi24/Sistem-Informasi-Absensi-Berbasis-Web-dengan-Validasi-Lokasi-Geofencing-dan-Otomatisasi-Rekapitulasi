<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->delete();

        Role::create(['nama_peran' => 'Admin']);
        Role::create(['nama_peran' => 'Pegawai']);
    }
}
