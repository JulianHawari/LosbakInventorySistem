<x-admin-layout title="Edit Template" header="Edit Template">

<x-card>
<form method="POST" action="{{ route('admin.template.update', $template) }}">
    @csrf
    @method('PUT')

    {{-- INFO TEMPLATE --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-input
            label="Nama Template"
            name="nama_template"
            value="{{ old('nama_template', $template->nama_template) }}"
            required
        />

        <x-input
            label="Keterangan"
            name="keterangan"
            value="{{ old('keterangan', $template->keterangan) }}"
        />
    </div>

    <hr class="my-6">

    {{-- BAHAN BAKU --}}
    <h3 class="font-semibold text-slate-700 mb-4">
        Bahan Baku Template
    </h3>

    <div id="bahan-wrapper" class="space-y-3">

        @foreach($template->details as $i => $detail)
        <div class="grid grid-cols-12 gap-3 items-center bahan-row">
            <div class="col-span-6">
                <select name="items[{{ $i }}][id_bahan]"
                        class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Pilih Bahan --</option>
                    @foreach($bahans as $b)
                        <option value="{{ $b->id_bahan }}"
                            {{ $b->id_bahan == $detail->id_bahan ? 'selected' : '' }}>
                            {{ $b->nama_bahan }} ({{ $b->satuan }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-4">
                <input type="number"
                       name="items[{{ $i }}][jumlah]"
                       value="{{ $detail->jumlah }}"
                       class="w-full border rounded-lg px-3 py-2"
                       min="1">
            </div>

            <div class="col-span-2">
                <button type="button"
                        onclick="hapusBaris(this)"
                        class="text-red-600 text-sm">
                    Hapus
                </button>
            </div>
        </div>
        @endforeach

    </div>

    <button type="button"
            onclick="tambahBaris()"
            class="text-blue-600 text-sm mt-4">
        + Tambah Bahan
    </button>

    {{-- ACTION --}}
    <div class="flex justify-end mt-8 gap-2">
        <a href="{{ route('admin.template.index') }}">
            <x-button variant="secondary">Batal</x-button>
        </a>

        <x-button>Simpan Perubahan</x-button>
    </div>

</form>
</x-card>

{{-- SCRIPT --}}
<script>
let index = {{ $template->details->count() }};

function tambahBaris() {
    const wrapper = document.getElementById('bahan-wrapper');

    wrapper.insertAdjacentHTML('beforeend', `
        <div class="grid grid-cols-12 gap-3 items-center bahan-row">
            <div class="col-span-6">
                <select name="items[${index}][id_bahan]"
                        class="w-full border rounded-lg px-3 py-2">
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
                       class="w-full border rounded-lg px-3 py-2"
                       min="1">
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
