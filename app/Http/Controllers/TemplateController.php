<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\TemplateDetail;
use App\Models\TemplateLosbak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = TemplateLosbak::with('details.bahan')->latest()->get();
        return view('admin.template.index', compact('templates'));
    }

    public function create()
    {
        $bahans = BahanBaku::orderBy('nama_bahan')->get();
        return view('admin.template.create', compact('bahans'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_template' => 'required|string|max:255',
        'keterangan' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.id_bahan' => 'required|exists:bahan_baku,id_bahan',
        'items.*.jumlah' => 'required|integer|min:1',
    ]);

    try {
        DB::transaction(function () use ($validated) {

            $template = TemplateLosbak::create([
                'nama_template' => $validated['nama_template'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            foreach ($validated['items'] as $it) {
                TemplateDetail::create([
                    'id_template' => $template->id_template,
                    'id_bahan' => $it['id_bahan'],
                    'jumlah' => $it['jumlah'],
                ]);
            }
        });

        return redirect()
            ->route('admin.template.index')
            ->with('success', 'Template berhasil dibuat');

    } catch (\Throwable $e) {
        return back()
            ->withInput()
            ->withErrors(['error' => 'Gagal menyimpan template: '.$e->getMessage()]);
    }
}


    public function edit(TemplateLosbak $template)
    {
        $template->load('details');
        $bahans = BahanBaku::orderBy('nama_bahan')->get();
        return view('admin.template.edit', compact('template','bahans'));
    }

    public function update(Request $request, TemplateLosbak $template)
{
    $validated = $request->validate([
        'nama_template' => 'required|string|max:255',
        'keterangan' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.id_bahan' => 'required|exists:bahan_baku,id_bahan',
        'items.*.jumlah' => 'required|integer|min:1',
    ]);

    try {
        DB::transaction(function () use ($validated, $template) {

            $template->update([
                'nama_template' => $validated['nama_template'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            TemplateDetail::where('id_template', $template->id_template)->delete();

            foreach ($validated['items'] as $it) {
                TemplateDetail::create([
                    'id_template' => $template->id_template,
                    'id_bahan' => $it['id_bahan'],
                    'jumlah' => $it['jumlah'],
                ]);
            }
        });

        return redirect()
            ->route('admin.template.index')
            ->with('success', 'Template berhasil diupdate');

    } catch (\Throwable $e) {
        return back()
            ->withInput()
            ->withErrors(['error' => 'Gagal update template: '.$e->getMessage()]);
    }
}


    public function destroy(TemplateLosbak $template)
    {
        $template->delete();
        return back()->with('success','Template dihapus.');
    }
}
