@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow p-6">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Ubah Data Buku</h1>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 p-4 text-red-800">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('buku.update', $buku) }}">
            @method('PUT')
            @include('buku._form')

            <div class="flex gap-3">
                <button type="submit" style="background-color:#3852B4;color:#fff;"
                        class="rounded-lg px-5 py-2 font-semibold hover:opacity-90">Simpan Perubahan</button>
                <a href="{{ route('buku.index') }}" style="background-color:#6b7280;color:#fff;"
                   class="rounded-lg px-5 py-2 font-semibold hover:opacity-90">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection