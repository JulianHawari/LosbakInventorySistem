<x-admin-layout title="Tambah Produksi" header="Tambah Produksi">

<x-card>
<form method="POST" action="{{ route('admin.produksi.store') }}">
@csrf

{{-- ERROR --}}
@if ($errors->any())
<div class="bg-red-100 text-red-700 p-4 rounded mb-4">
    <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- JENIS --}}
<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Jenis Produksi</label>
    <select id="jenis" name="jenis" class="w-full border rounded-lg px-3 py-2">
        <option value="template">Template</option>
        <option value="custom">Custom</option>
    </select>
</div>

{{-- TANGGAL --}}
<x-input label="Tanggal" name="tanggal" type="date" required />

<x-input label="Tipe" name="tipe" />
<x-input label="Catatan" name="catatan" />

{{-- TEMPLATE --}}
<div id="template-section" class="space-y-4">
    <div>
        <label class="block text-sm font-medium mb-1">Template</label>
        <select id="templateSelect" name="id_template"
                class="w-full border rounded-lg px-3 py-2">
            <option value="">-- Pilih Template --</option>
            @foreach($templates as $t)
                <option value="{{ $t->id_template }}"
                        data-items='@json($t->details)'>
                    {{ $t->nama_template }}
                </option>
            @endforeach
        </select>
    </div>

    <x-input label="Jumlah Produksi" name="jumlah_produksi" type="number" min="1" value="1" />
</div>

{{-- CUSTOM ITEMS --}}
<div id="custom-section" class="hidden">
    <h3 class="font-semibold mb-2">Bahan Baku (Custom)</h3>
    <div id="items-wrapper" class="space-y-3"></div>

    <button type="button" onclick="tambahItem()"
            class="text-blue-600 text-sm mt-2">
        + Tambah Bahan
    </button>
</div>

<div class="flex justify-end mt-8">
    <x-button>Simpan Produksi</x-button>
</div>

</form>
</x-card>

<script>
const jenis = document.getElementById('jenis');
const templateSection = document.getElementById('template-section');
const customSection = document.getElementById('custom-section');
const wrapper = document.getElementById('items-wrapper');

jenis.addEventListener('change', toggleJenis);
toggleJenis();

function toggleJenis() {
    if (jenis.value === 'template') {
        templateSection.classList.remove('hidden');
        customSection.classList.add('hidden');
        wrapper.innerHTML = '';
    } else {
        templateSection.classList.add('hidden');
        customSection.classList.remove('hidden');
    }
}

let idx = 0;
function tambahItem() {
    wrapper.insertAdjacentHTML('beforeend', `
    <div class="grid grid-cols-12 gap-3 items-center">
        <div class="col-span-6">
            <select name="items[${idx}][id_bahan]"
                class="w-full border rounded-lg px-3 py-2">
                <option value="">-- Pilih Bahan --</option>
                @foreach(\App\Models\BahanBaku::orderBy('nama_bahan')->get() as $b)
                    <option value="{{ $b->id_bahan }}">
                        {{ $b->nama_bahan }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-span-4">
            <input type="number"
                   name="items[${idx}][jumlah]"
                   min="1"
                   class="w-full border rounded-lg px-3 py-2"
                   placeholder="Jumlah">
        </div>
        <div class="col-span-2">
            <button type="button"
                    onclick="this.closest('div.grid').remove()"
                    class="text-red-600 text-sm">
                Hapus
            </button>
        </div>
    </div>
    `);
    idx++;
}
</script>

</x-admin-layout>
