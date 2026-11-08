<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    /**
     * SOAL 4: siapa yang boleh melihat satu data peminjaman.
     * - admin dan petugas: boleh melihat semua peminjaman
     * - siswa: hanya peminjaman miliknya sendiri
     * - selain itu: ditolak
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;
        }

        if ($user->hasRole('siswa')) {
            $anggota = $user->anggota;

            return $anggota !== null
                && (int) $anggota->id === (int) $peminjaman->anggota_id;
        }

        return false;
    }
}