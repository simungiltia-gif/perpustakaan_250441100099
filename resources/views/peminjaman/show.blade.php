@extends('layouts.app')

@section('title', 'Detail Peminjaman - Perpustakaan Digital')

@section('content')
@php
    $status = strtolower(trim((string) $peminjaman->status));
@endphp

<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow p-6">

        <div class="mb-6 rounded-xl p-5 text-white" style="background:linear-gradient(135deg,#5E7AC4,#3852B4);">
            <h1 class="text-xl font-bold">Detail Peminjaman #{{ $peminjaman->id }}</h1>
            <p class="text-sm opacity-90 mt-1">Informasi lengkap transaksi peminjaman buku</p>
        </div>

        <table class="w-full text-left">
            <tbody>
                <tr class="border-b">
                    <th class="py-3 pr-4 w-1/3 text-gray-500 font-semibold">Nama Anggota</th>
                    <td class="py-3">{{ $peminjaman->anggota->nama ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <th class="py-3 pr-4 text-gray-500 font-semibold">Email Anggota</th>
                    <td class="py-3">{{ $peminjaman->anggota->email ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <th class="py-3 pr-4 text-gray-500 font-semibold">Judul Buku</th>
                    <td class="py-3">{{ $peminjaman->buku->judul ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <th class="py-3 pr-4 text-gray-500 font-semibold">Tanggal Pinjam</th>
                    <td class="py-3">{{ $peminjaman->tanggal_pinjam }}</td>
                </tr>
                <tr class="border-b">
                    <th class="py-3 pr-4 text-gray-500 font-semibold">Tanggal Kembali</th>
                    <td class="py-3">{{ $peminjaman->tanggal_kembali ?? 'Belum dikembalikan' }}</td>
                </tr>
                <tr>
                    <th class="py-3 pr-4 text-gray-500 font-semibold">Status</th>
                    <td class="py-3">{{ ucfirst($status ?: 'menunggu') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6">
            <a href="{{ route('dashboard') }}" style="background-color:#3852B4;color:#fff;"
               class="inline-block rounded-lg px-5 py-2 font-semibold hover:opacity-90">← Kembali ke Dashboard</a>
        </div>
    </div>
</div>
@endsection