<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::with('user')->latest();

        if ($request->has('jenis') && $request->jenis != '') {
            $query->byJenis($request->jenis);
        }

        if ($request->has('status') && $request->status != '') {
            $query->byStatus($request->status);
        }

        $surat = $query->paginate(10);
        $users = User::all();

        return view('surat.index', compact('surat', 'users'));
    }

    public function create()
    {
        $users = User::all();
        return view('surat.create', compact('users'));
    }

    public function template()
    {
        $users = User::all();
        return view('surat.template', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat' => 'required|in:permohonan,pemberitahuan,undangan,keterangan,pengantar,izin',
            'perihal' => 'required|string|max:255',
            'kepada' => 'required|string|max:255',
            'isi_surat' => 'required|string',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'kontak_instansi' => 'required|string|max:255',
            'nama_penandatangan' => 'required|string|max:255',
            'jabatan_penandatangan' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $nomorSurat = $request->nomor_surat ?: Surat::generateNomorSurat($request->jenis_surat);

        $surat = Surat::create([
            'user_id' => Auth::id(),
            'jenis_surat' => $request->jenis_surat,
            'nomor_surat' => $nomorSurat,
            'perihal' => $request->perihal,
            'kepada' => $request->kepada,
            'isi_surat' => $request->isi_surat,
            'nama_instansi' => $request->nama_instansi,
            'alamat_instansi' => $request->alamat_instansi,
            'kontak_instansi' => $request->kontak_instansi,
            'nama_penandatangan' => $request->nama_penandatangan,
            'jabatan_penandatangan' => $request->jabatan_penandatangan,
            'status' => 'draft',
            'tanggal_surat' => $request->tanggal_surat,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('surat.show', $surat->id)
                        ->with('success', 'Surat berhasil dibuat.');
    }

    public function show(Surat $surat)
    {
        return view('surat.show', compact('surat'));
    }

    public function edit(Surat $surat)
    {
        $users = User::all();
        return view('surat.edit', compact('surat', 'users'));
    }

    public function update(Request $request, Surat $surat)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat' => 'required|in:permohonan,pemberitahuan,undangan,keterangan,pengantar,izin',
            'perihal' => 'required|string|max:255',
            'kepada' => 'required|string|max:255',
            'isi_surat' => 'required|string',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'kontak_instansi' => 'required|string|max:255',
            'nama_penandatangan' => 'required|string|max:255',
            'jabatan_penandatangan' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $surat->update($request->all());

        return redirect()->route('surat.show', $surat->id)
                        ->with('success', 'Surat berhasil diupdate.');
    }

    public function destroy(Surat $surat)
    {
        $surat->delete();

        return redirect()->route('surat.index')
                        ->with('success', 'Surat berhasil dihapus.');
    }

    public function updateStatus(Request $request, Surat $surat)
    {
        $request->validate([
            'status' => 'required|in:draft,dikirim,disetujui,ditolak',
            'catatan' => 'nullable|string'
        ]);

        $surat->update([
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);

        return redirect()->back()
                        ->with('success', 'Status surat berhasil diupdate.');
    }

    public function getTemplate(Request $request)
    {
        $jenis = $request->get('jenis', 'permohonan');
        $template = Surat::getTemplateIsi($jenis);

        return response()->json([
            'template' => $template,
            'perihal' => ucfirst($jenis)
        ]);
    }

    public function print(Surat $surat)
    {
        return view('surat.print', compact('surat'));
    }

    public function exportPdf(Surat $surat)
    {
        return redirect()->back()->with('info', 'Fitur export PDF belum diimplementasi');
    }

    public function stats()
    {
        $stats = [
            'total_surat' => Surat::count(),
            'surat_draft' => Surat::where('status', 'draft')->count(),
            'surat_dikirim' => Surat::where('status', 'dikirim')->count(),
            'surat_disetujui' => Surat::where('status', 'disetujui')->count(),
            'surat_ditolak' => Surat::where('status', 'ditolak')->count(),
            'total_users' => User::count(),
            'surat_per_user' => User::withCount('surat')->get()
        ];

        return view('surat.stats', compact('stats'));
    }
}
