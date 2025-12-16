<x-admin-layout title="Edit Bahan" header="Edit Bahan Baku">

<x-card>
<form method="POST" action="{{ route('admin.bahan.update', $bahan) }}">
    @csrf
    @method('PUT')

    <x-input
        label="Nama Bahan"
        name="nama_bahan"
        value="{{ old('nama_bahan', $bahan->nama_bahan) }}"
        required
    />

    <x-input
        label="Satuan"
        name="satuan"
        value="{{ old('satuan', $bahan->satuan) }}"
        required
    />

    <x-input
        label="Stok"
        name="stok"
        type="number"
        value="{{ old('stok', $bahan->stok) }}"
        required
    />

    <div class="flex justify-end gap-2 mt-6">
        <a href="{{ route('admin.bahan.index') }}"
           class="px-4 py-2 rounded-lg border">
            Batal
        </a>
        <x-button>Simpan Perubahan</x-button>
    </div>
</form>
</x-card>

</x-admin-layout>
