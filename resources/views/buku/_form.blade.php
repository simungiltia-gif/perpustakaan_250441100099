@csrf

<div class="mb-4">
    <label for="kategori_id" class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
    <select id="kategori_id" name="kategori_id" required
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">-- Pilih kategori --</option>
        @foreach ($kategoris as $kategori)
            <option value="{{ $kategori->id }}"
                @selected(old('kategori_id', $buku->kategori_id ?? '') == $kategori->id)>
                {{ $kategori->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label for="judul" class="block text-sm font-semibold text-gray-700 mb-1">Judul</label>
    <input id="judul" type="text" name="judul" maxlength="150" required
           value="{{ old('judul', $buku->judul ?? '') }}"
           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
</div>

<div class="mb-4">
    <label for="penulis" class="block text-sm font-semibold text-gray-700 mb-1">Penulis</label>
    <input id="penulis" type="text" name="penulis" maxlength="100" required
           value="{{ old('penulis', $buku->penulis ?? '') }}"
           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
</div>

<div class="mb-6">
    <label for="tahun_terbit" class="block text-sm font-semibold text-gray-700 mb-1">Tahun Terbit</label>
    <input id="tahun_terbit" type="number" name="tahun_terbit" min="1900" max="{{ date('Y') }}" required
           value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}"
           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
</div>