<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::with('user')->latest();

        if ($request->filled('jenis')) {
            $query->where('jenis_surat', $request->jenis);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $surat = $query->paginate(10);

        return view('surat.index', compact('surat'));
    }

    public function create()
    {
        return view('surat.template');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required|string',
            'nomor_surat' => 'required|string|unique:surats,nomor_surat',
            'perihal' => 'required|string',
            'kepada' => 'required|string',
            'isi_surat' => 'required|string',
            'nama_instansi' => 'required|string',
            'alamat_instansi' => 'required|string',
            'kontak_instansi' => 'required|string',
            'nama_penandatangan' => 'required|string',
            'jabatan_penandatangan' => 'required|string',
            'tanggal_surat' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        $surat = Surat::create([
            'user_id' => Auth::id(),
            'jenis_surat' => $request->jenis_surat,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'kepada' => $request->kepada,
            'isi_surat' => $request->isi_surat,
            'nama_instansi' => $request->nama_instansi,
            'alamat_instansi' => $request->alamat_instansi,
            'kontak_instansi' => $request->kontak_instansi,
            'nama_penandatangan' => $request->nama_penandatangan,
            'jabatan_penandatangan' => $request->jabatan_penandatangan,
            'tanggal_surat' => $request->tanggal_surat,
            'catatan' => $request->catatan,
            'status' => 'draft',
        ]);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dibuat.');
    }


    public function show(Surat $surat)
    {
        return view('surat.show', compact('surat'));
    }

    public function edit(Surat $surat)
    {
        return view('surat.edit', compact('surat'));
    }

    public function update(Request $request, Surat $surat)
    {
        $request->validate([
            'perihal' => 'required|string',
            'kepada' => 'required|string',
            'isi_surat' => 'required|string',
            'nama_penandatangan' => 'required|string',
            'jabatan_penandatangan' => 'required|string',
            'status' => 'required|string',
        ]);

        $surat->update($request->only([
            'perihal',
            'kepada',
            'isi_surat',
            'nama_penandatangan',
            'jabatan_penandatangan',
            'status',
            'catatan',
        ]));

        return redirect()->route('surat.index')->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat)
    {
        $surat->delete();
        return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus.');
    }

    // Tambahan: Endpoint generate nomor otomatis (AJAX kalau perlu)
    public function generateNomorSurat()
    {
        $nomor = $this->createAutoNomor();
        return response()->json(['nomor' => $nomor]);
    }

    // Fungsi untuk bikin nomor unik
    private function createAutoNomor()
    {
        $count = Surat::count() + 1;
        $month = date('m');
        $year = date('Y');
        return sprintf('%03d/SRT/%s/%s', $count, $month, $year);
    }

    public function activities(): HasMany
{
    return $this->hasMany(Activity::class, 'surat_id');
}

}
