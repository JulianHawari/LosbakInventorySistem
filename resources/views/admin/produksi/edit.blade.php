<x-admin-layout title="Edit Produksi" header="Edit Produksi">

<x-card>
<form method="POST" action="{{ route('admin.produksi.update',$produksi) }}">
@csrf
@method('PUT')

{{-- jenis --}}
<input type="hidden" name="jenis" value="{{ $produksi->jenis }}">

<x-input label="Tanggal" name="tanggal" type="date"
         value="{{ $produksi->tanggal }}" required />

<x-input label="Tipe" name="tipe" value="{{ $produksi->tipe }}" />
<x-input label="Catatan" name="catatan" value="{{ $produksi->catatan }}" />

@if($produksi->jenis === 'template')
    <input type="hidden" name="id_template" value="{{ $produksi->id_template }}">
    <input type="hidden" name="jumlah_produksi" value="{{ $produksi->jumlah_produksi }}">
@else
    <h3 class="font-semibold mb-2">Bahan Baku</h3>
    @foreach($produksi->details as $i => $d)
        <div class="grid grid-cols-12 gap-3 mb-2">
            <input type="hidden"
                   name="items[{{ $i }}][id_bahan]"
                   value="{{ $d->id_bahan }}">
            <div class="col-span-6">
                <input class="w-full border rounded-lg px-3 py-2 bg-gray-100"
                       value="{{ $d->bahan->nama_bahan }}" readonly>
            </div>
            <div class="col-span-4">
                <input type="number"
                       name="items[{{ $i }}][jumlah]"
                       value="{{ $d->jumlah_dipakai }}"
                       min="1"
                       class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
    @endforeach
@endif

<div class="flex justify-end mt-6">
    <x-button>Simpan Perubahan</x-button>
</div>

</form>
</x-card>

</x-admin-layout>
