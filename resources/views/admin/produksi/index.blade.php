<x-admin-layout title="Produksi" header="Produksi">

    {{-- SUB MENU / TAB --}}
    <div class="flex gap-2 mb-6">
        <a href="{{ route('admin.produksi.index') }}">
            <x-button :variant="$mode === 'proses' ? 'primary' : 'secondary'">
                Proses Produksi
            </x-button>
        </a>

        <a href="{{ route('admin.produksi.selesai') }}">
            <x-button :variant="$mode === 'selesai' ? 'primary' : 'secondary'">
                Hasil Produksi
            </x-button>
        </a>
    </div>

    {{-- TOMBOL TAMBAH HANYA DI PROSES --}}
    @if($mode === 'proses')
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.produksi.create') }}">
            <x-button>+ Tambah Produksi</x-button>
        </a>
    </div>
    @endif

    <x-card class="p-0">
        <table class="w-full text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="p-4 text-left">Tanggal</th>
                    <th class="p-4">Jenis</th>
                    <th class="p-4">Template</th>
                    <th class="p-4">Jumlah</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($produksis as $p)
                <tr class="border-t hover:bg-slate-50">
                    <td class="p-4">{{ $p->tanggal }}</td>
                    <td class="p-4 capitalize">{{ $p->jenis }}</td>
                    <td class="p-4">{{ $p->template?->nama_template ?? '-' }}</td>
                    <td class="p-4">{{ $p->jumlah_produksi }}</td>

                    {{-- STATUS --}}
                    <td class="p-4 text-center">
                        @if($mode === 'proses')
                            <form method="POST"
                                  action="{{ route('admin.produksi.toggleStatus', $p) }}"
                                  onsubmit="return confirm('Tandai produksi ini sebagai SELESAI?')">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                    bg-yellow-100 text-yellow-700 hover:bg-yellow-200">
                                    PROSES
                                </button>
                            </form>
                        @else
                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold
                                bg-green-100 text-green-700">
                                SELESAI
                            </span>
                        @endif
                    </td>
                <td class="p-4 text-center space-x-2">

                    {{-- DETAIL (SELALU ADA) --}}
                    <a href="{{ route('admin.produksi.spk', $p->id_produksi) }}"
                    target="_blank"
                    class="text-blue-600 font-semibold">
                        Detail
                    </a>

                    {{-- EDIT (HANYA SAAT PROSES) --}}
                    @if($mode === 'proses')
                        <a href="{{ route('admin.produksi.edit',$p) }}"
                        class="text-indigo-600">
                            Edit
                        </a>
                    @endif

                </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-slate-500">
                        Tidak ada data produksi.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </x-card>

</x-admin-layout>
