@extends('layouts.app')

@section('title', 'Daftar Buku - Perpustakaan Digital')

@section('content')
@php
    $bolehKelola = auth()->user()->hasAnyRole(['admin', 'petugas']);
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Data Buku Perpustakaan Digital</h1>

        @if ($bolehKelola)
            <a href="{{ route('buku.create') }}" style="background-color:#3852B4;color:#fff;"
               class="rounded-lg px-4 py-2 font-semibold hover:opacity-90">+ Tambah Buku</a>
        @endif
    </div>

    @if (session('success'))
        <div class="mb-4 rounded bg-green-100 p-4 text-green-800">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded bg-red-100 p-4 text-red-800">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto rounded-xl bg-white p-6 shadow">
        <table class="w-full border-collapse">
            <thead style="background-color:#f3f4f6;">
                <tr>
                    <th class="border px-4 py-3 text-left">Kategori</th>
                    <th class="border px-4 py-3 text-left">Judul</th>
                    <th class="border px-4 py-3 text-left">Penulis</th>
                    <th class="border px-4 py-3 text-left">Tahun Terbit</th>
                    <th class="border px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bukus as $buku)
                    <tr>
                        <td class="border px-4 py-3">{{ $buku->kategori->nama ?? '-' }}</td>

                        {{-- SOAL 2(a): {{ }} melakukan escaping HTML --}}
                        <td class="border px-4 py-3">{{ $buku->judul }}</td>

                        <td class="border px-4 py-3">{{ $buku->penulis }}</td>
                        <td class="border px-4 py-3">{{ $buku->tahun_terbit }}</td>
                        <td class="border px-4 py-3">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('buku.show', $buku->id) }}" style="background-color:#0891b2;color:#fff;"
                                   class="rounded px-3 py-1 text-sm font-semibold">Detail</a>

                                @if ($bolehKelola)
                                    <a href="{{ route('buku.edit', $buku) }}" style="background-color:#d97706;color:#fff;"
                                       class="rounded px-3 py-1 text-sm font-semibold">Ubah</a>

                                    {{-- SOAL 2(c): hapus lewat form DELETE + token CSRF --}}
                                    <form method="POST" action="{{ route('buku.destroy', $buku) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background-color:#dc2626;color:#fff;"
                                                class="rounded px-3 py-1 text-sm font-semibold">Hapus</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('peminjaman.ajukan') }}">
                                        @csrf
                                        <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                        <button type="submit" style="background-color:#16a34a;color:#fff;"
                                                class="rounded px-3 py-1 text-sm font-semibold">Pinjam</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-6 text-center text-gray-500">Belum ada data buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection