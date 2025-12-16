<x-admin-layout title="Template Produksi" header="Template Produksi">

    <div class="flex justify-between items-center mb-6">
        <div class="text-slate-600 text-sm">
            Kelola template produksi dan bahan bakunya
        </div>

        <a href="{{ route('admin.template.create') }}">
            <x-button>+ Tambah Template</x-button>
        </a>
    </div>

    {{-- JIKA ADA DATA --}}
    @if($templates->count())
        <x-card class="p-0">
            <table class="w-full text-sm">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="p-4 text-left">Nama Template</th>
                        <th class="p-4 text-left">Keterangan</th>
                        <th class="p-4 text-center">Jumlah Bahan</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($templates as $t)
                    <tr class="border-t hover:bg-slate-50">
                        <td class="p-4 font-medium">{{ $t->nama_template }}</td>
                        <td class="p-4 text-slate-600">
                            {{ $t->keterangan ?? '-' }}
                        </td>
                        <td class="p-4 text-center">
                            {{ $t->details->count() }}
                        </td>
                        <td class="p-4 text-center space-x-2">
                            <a href="{{ route('admin.template.edit',$t) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.template.destroy',$t) }}"
                                  class="inline"
                                  onsubmit="return confirm('Hapus template ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </x-card>

    {{-- EMPTY STATE --}}
    @else
        <x-card class="text-center py-16">
            <div class="text-5xl mb-4">📦</div>
            <h3 class="text-lg font-semibold text-slate-700">
                Belum ada template produksi
            </h3>
            <p class="text-slate-500 mt-2 mb-6">
                Template digunakan untuk menentukan bahan baku otomatis saat produksi
            </p>

            <a href="{{ route('admin.template.create') }}">
                <x-button>+ Tambah Template Pertama</x-button>
            </a>
        </x-card>
    @endif

</x-admin-layout>
