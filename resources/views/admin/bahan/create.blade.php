<x-admin-layout title="Tambah Bahan" header="Tambah Bahan">
    <x-card>
        <form method="POST" action="{{ route('admin.bahan.store') }}">
            @csrf
            <x-input label="Nama Bahan" name="nama_bahan" />
            <x-input label="Satuan" name="satuan" />
            <x-input label="Stok Awal" name="stok" type="number" />

            <div class="flex justify-end">
                <x-button>Simpan</x-button>
            </div>
        </form>
    </x-card>
</x-admin-layout>
