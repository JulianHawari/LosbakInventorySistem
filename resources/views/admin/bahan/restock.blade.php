<x-admin-layout
    title="Restock Bahan"
    header="Restock: {{ $bahan->nama_bahan }}"
>

<x-card>
    <form method="POST" action="{{ route('admin.bahan.restock', $bahan) }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <x-input
                label="Nama Bahan"
                :value="$bahan->nama_bahan"
                disabled
            />

            <x-input
                label="Stok Saat Ini"
                :value="$bahan->stok . ' ' . $bahan->satuan"
                disabled
            />

            <x-input
                label="Jumlah Tambah"
                name="jumlah"
                type="number"
                min="1"
                required
            />

            <x-input
                label="Tanggal"
                name="tanggal"
                type="date"
                value="{{ now()->toDateString() }}"
                required
            />

            <div class="md:col-span-2">
                <x-input
                    label="Keterangan"
                    name="keterangan"
                    placeholder="Contoh: beli bahan / supplier A"
                />
            </div>
        </div>

        <div class="flex justify-end mt-8 gap-2">
            <a href="{{ route('admin.bahan.index') }}">
                <x-button variant="secondary">
                    Batal
                </x-button>
            </a>

            <x-button>
                Simpan Restock
            </x-button>
        </div>
    </form>
</x-card>

</x-admin-layout>
