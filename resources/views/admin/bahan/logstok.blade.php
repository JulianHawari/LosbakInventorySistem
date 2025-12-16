<x-admin-layout title="Log Stok" header="Log Stok Bahan Baku">

<div class="mb-4 text-slate-600 text-sm">
    Riwayat semua pergerakan stok bahan baku (masuk & keluar)
</div>
    <form method="POST"
          action="{{ route('admin.bahan.logstok.clear') }}"
          onsubmit="return confirm('Yakin mau hapus SEMUA log stok?')">
        @csrf
        @method('DELETE')

        <x-button variant="danger">
            🗑️ Clear Log
        </x-button>
    </form>
<x-card class="p-0">
<table class="w-full text-sm">
    <thead class="bg-slate-100">
        <tr>
            <th class="p-4 text-left">Tanggal</th>
            <th class="p-4 text-left">Bahan</th>
            <th class="p-4 text-center">Perubahan</th>
            <th class="p-4 text-center">Jumlah</th>
            <th class="p-4 text-left">Keterangan</th>
            <th class="p-4 text-left">Sumber</th>
        </tr>
    </thead>
    <tbody>
    @foreach($logs as $log)
        <tr class="border-t hover:bg-slate-50">
            <td class="p-4">{{ $log->tanggal }}</td>

            <td class="p-4 font-medium">
                {{ $log->bahan->nama_bahan }}
            </td>

                <td class="p-4 text-center">
            @if($log->tipe === 'IN')
                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                    +
                </span>
            @else
                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                    −
                </span>
            @endif
        </td>


            <td class="p-4 text-center">{{ $log->jumlah }}</td>

            <td class="p-4 text-slate-600">
                {{ $log->keterangan }}
            </td>

            <td class="p-4">
    @switch($log->ref_type)
        @case('init')
            <span class="text-slate-600">Stok Awal</span>
            @break

        @case('restock')
            <span class="text-green-600 font-medium">Restock</span>
            @break

        @case('produksi')
            <span class="text-blue-600 font-medium">Produksi</span>
            @break

        @case('produksi_update')
            <span class="text-indigo-600 font-medium">Update Produksi</span>
            @break

        @case('produksi_edit_rollback')
            <span class="text-orange-600 font-medium">Rollback Edit</span>
            @break

        @case('produksi_delete_rollback')
            <span class="text-red-600 font-medium">Rollback Hapus</span>
            @break

        @default
            <span class="text-slate-400">-</span>
    @endswitch
</td>

        </tr>
    @endforeach
    </tbody>
</table>
</x-card>

<div class="mt-4">
    {{ $logs->links() }}
</div>

</x-admin-layout>
