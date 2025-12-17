<x-admin-layout
    title="Tambah Stok"
    header="Tambah Stok: {{ $bahan->nama_bahan }}"
>

    <div class="mb-4 text-slate-600 text-sm">
        Menambahkan stok bahan baku ke sistem
    </div>

    <x-card>
        <form
            method="POST"
            action="{{ route('admin.bahan.restock', $bahan) }}"
            class="space-y-4"
        >
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Jumlah
                </label>
                <input
                    type="number"
                    name="jumlah"
                    min="1"
                    required
                    class="w-full rounded border-slate-300 focus:ring focus:ring-slate-200"
                    placeholder="Masukkan jumlah stok"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Tanggal
                </label>
                <input
                    type="date"
                    name="tanggal"
                    value="{{ now()->toDateString() }}"
                    required
                    class="w-full rounded border-slate-300 focus:ring focus:ring-slate-200"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Keterangan
                </label>
                <input
                    type="text"
                    name="keterangan"
                    class="w-full rounded border-slate-300 focus:ring focus:ring-slate-200"
                    placeholder="Contoh: beli bahan"
                >
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <a
                    href="{{ route('admin.bahan.index') }}"
                    class="px-4 py-2 text-sm rounded border border-slate-300 text-slate-600 hover:bg-slate-50"
                >
                    Batal
                </a>

                <x-button variant="primary">
                    Simpan
                </x-button>
            </div>
        </form>
    </x-card>

</x-admin-layout>
