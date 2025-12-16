<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tambah Stok: {{ $bahan->nama_bahan }}</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('admin.bahan.restock', $bahan) }}">
            @csrf
            <div>
                <label>Jumlah</label>
                <input class="border p-2 w-full" type="number" name="jumlah" min="1" required>
            </div>
            <div class="mt-3">
                <label>Tanggal</label>
                <input class="border p-2 w-full" type="date" name="tanggal" value="{{ now()->toDateString() }}" required>
            </div>
            <div class="mt-3">
                <label>Keterangan</label>
                <input class="border p-2 w-full" type="text" name="keterangan" placeholder="Contoh: beli bahan">
            </div>

            <button class="mt-4 border px-4 py-2">Simpan</button>
        </form>
    </div>
</x-app-layout>
