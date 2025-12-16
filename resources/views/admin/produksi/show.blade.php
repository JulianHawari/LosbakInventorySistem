<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Detail Produksi #{{ $produksi->id_produksi }}</h2></x-slot>

    <div class="p-6">
        <div>Jenis: <b>{{ $produksi->jenis }}</b></div>
        <div>Tanggal: <b>{{ $produksi->tanggal }}</b></div>
        <div>Status: <b>{{ $produksi->status }}</b></div>
        <div>Template: <b>{{ $produksi->template?->nama_template ?? '-' }}</b></div>

        <table class="mt-4 w-full border">
            <tr class="border">
                <th class="p-2 border">Bahan</th>
                <th class="p-2 border">Jumlah dipakai</th>
            </tr>
            @foreach($produksi->details as $d)
                <tr class="border">
                    <td class="p-2 border">{{ $d->bahan->nama_bahan }}</td>
                    <td class="p-2 border">{{ $d->jumlah_dipakai }} {{ $d->bahan->satuan }}</td>
                </tr>
            @endforeach
        </table>

        <a class="underline mt-4 inline-block" href="{{ route('admin.produksi.index') }}">← Kembali</a>
    </div>
</x-app-layout>
