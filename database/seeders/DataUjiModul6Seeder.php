<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataUjiModul6Seeder extends Seeder
{
    public function run(): void
    {
        $siswa1 = User::where('email', 'siswa@gmail.com')->firstOrFail();

        $siswa2 = User::firstOrCreate(
            ['email' => 'siswa2@gmail.com'],
            ['name' => 'Siswa Dua 250441100099', 'password' => Hash::make('password123')]
        );
        $siswa2->syncRoles(['siswa']);

        $buku = Buku::first() ?? Buku::factory()->create();

        foreach ([$siswa1, $siswa2] as $user) {
            $anggota = $user->anggotaOrCreate();

            $pinjam = Peminjaman::firstOrCreate(
                ['anggota_id' => $anggota->id, 'buku_id' => $buku->id],
                ['tanggal_pinjam' => now()->toDateString(), 'status' => 'dipinjam']
            );

            $this->command?->info("Peminjaman milik {$user->email}: /peminjaman/{$pinjam->id}");
        }
    }
}