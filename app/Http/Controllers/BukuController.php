<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')->latest('id')->get();
        return view('buku.index', compact('bukus'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    public function create()
    {
        return view('buku.create', ['kategoris' => Kategori::all()]);
    }

    public function store(StoreBukuRequest $request)
    {
        Buku::create($request->validated());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', ['buku' => $buku, 'kategoris' => Kategori::all()]);
    }

    public function update(UpdateBukuRequest $request, Buku $buku)
    {
        $buku->update($request->validated());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    // A2 (SENGAJA RENTAN): judul digabung langsung ke SQL
   public function cari(Request $request)
{
    $judul = $request->query('judul');

    $hasil = DB::select('SELECT * FROM bukus WHERE judul = ?', [$judul]);

    return response()->json($hasil);
}
}