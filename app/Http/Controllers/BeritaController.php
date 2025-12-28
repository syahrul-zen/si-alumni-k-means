<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::guard('admin_pimpinan')->user()->is_admin) {
            return redirect('/');
        }

        return view("Admin.Berita.index", [
            'beritas' => Berita::orderByDesc('tanggal')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::guard('admin_pimpinan')->user()->is_admin) {
            return redirect('/');
        }

        return view('Admin.Berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:240|unique:beritas',
            'tanggal' => 'required',
            'gambar' => 'required|max:2100',
            'deskripsi' => 'required'
        ]);

        $getImage = $request->file("gambar");

        $renameFile = uniqid() . "_" . $getImage->getClientOriginalName();

        $locationFile = 'File';

        $validated['gambar'] = $renameFile;

        $getImage->move($locationFile, $renameFile);

        Berita::create($validated);

        return redirect('berita')->with('success', "Berhasil menambahkan berita");

    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $beritum)
    {
        return view("Alumni.show-berita", [
            'berita' => $beritum
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $beritum)
    {
        if (!Auth::guard('admin_pimpinan')->user()->is_admin) {
            return redirect('/');
        }

        return view("Admin.Berita.edit", [
            'berita' => $beritum
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $beritum)
    {

         $validated = $request->validate([
            'judul' => 'required|max:240|unique:beritas,judul,' . $beritum->id,
            'tanggal' => 'required',
            'gambar' => 'nullable|image|max:2100',
            'deskripsi' => 'required'
        ]);

        // Jika upload gambar baru
        if ($request->hasFile('gambar')) {



            $getImage = $request->file('gambar');
            $renameFile = uniqid() . "_" . $getImage->getClientOriginalName();
            $locationFile = 'File';

            $getImage->move($locationFile, $renameFile);
            $validated['gambar'] = $renameFile;

            File::delete('File/' . $beritum->gambar );
        }

        // Update data beritum
        $beritum->update($validated);

        return redirect('berita')->with('success', 'Berita berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $beritum)
    {
        File::delete('File/' . $beritum->gambar);

        $beritum->delete();

        return back()->with("success", "Berhasil menghapus data berita");
    }
}
