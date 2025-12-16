<x-admin-layout title="Tambah Template" header="Tambah Template">

<x-card>
<form method="POST" action="{{ route('admin.template.store') }}">
@csrf

{{-- ERROR VALIDASI (WAJIB BIAR KELIHATAN) --}}
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- INFO TEMPLATE --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <x-input label="Nama Template" name="nama_template" required />
    <x-input label="Keterangan" name="keterangan" />
</div>

<hr class="my-6">

<h3 class="font-semibold text-slate-700 mb-4">Bahan Baku</h3>

<div id="bahan-wrapper" class="space-y-3">

    <div class="grid grid-cols-12 gap-3 items-center bahan-row">
        <div class="col-span-6">
            <select name="items[0][id_bahan]"
                class="w-full border rounded-lg px-3 py-2" required>
                <option value="">-- Pilih Bahan --</option>
                @foreach($bahans as $b)
                    <option value="{{ $b->id_bahan }}">
                        {{ $b->nama_bahan }} ({{ $b->satuan }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-span-4">
            <input type="number"
                   name="items[0][jumlah]"
                   min="1"
                   required
                   placeholder="Jumlah"
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="col-span-2">
            <button type="button"
                    onclick="hapusBaris(this)"
                    class="text-red-600 text-sm">
                Hapus
            </button>
        </div>
    </div>

</div>

<button type="button"
        onclick="tambahBaris()"
        class="text-blue-600 text-sm mt-4">
    + Tambah Bahan
</button>

<div class="flex justify-end mt-8">
    <x-button>Simpan Template</x-button>
</div>

</form>
</x-card>

<script>
let index = 1;

function tambahBaris() {
    const wrapper = document.getElementById('bahan-wrapper');

    wrapper.insertAdjacentHTML('beforeend', `
    <div class="grid grid-cols-12 gap-3 items-center bahan-row">
        <div class="col-span-6">
            <select name="items[${index}][id_bahan]"
                class="w-full border rounded-lg px-3 py-2" required>
                <option value="">-- Pilih Bahan --</option>
                @foreach($bahans as $b)
                    <option value="{{ $b->id_bahan }}">
                        {{ $b->nama_bahan }} ({{ $b->satuan }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-span-4">
            <input type="number"
                   name="items[${index}][jumlah]"
                   min="1"
                   required
                   placeholder="Jumlah"
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="col-span-2">
            <button type="button"
                    onclick="hapusBaris(this)"
                    class="text-red-600 text-sm">
                Hapus
            </button>
        </div>
    </div>
    `);

    index++;
}

function hapusBaris(btn) {
    btn.closest('.bahan-row').remove();
}
</script>

</x-admin-layout>
