    <x-admin-layout title="Bahan Baku" header="Bahan Baku">
        <div class="flex justify-end mb-6">
            <a href="{{ route('admin.bahan.create') }}">
                <x-button>+ Tambah Bahan</x-button>
            </a>
            <a href="{{ route('admin.bahan.logstok') }}">
            <x-button variant="secondary">
                📄 Log Stok
            </x-button>
        </a>
        </div>

        <x-card class="p-0">
            <table class="w-full text-sm">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4">Satuan</th>
                        <th class="p-4">Stok</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($bahans as $b)
                    <tr class="border-t hover:bg-slate-50">
                        <td class="p-4">{{ $b->nama_bahan }}</td>
                        <td class="p-4">{{ $b->satuan }}</td>
                        <td class="p-4">{{ $b->stok }}</td>
                        <td class="p-4 text-center space-x-3">
                            {{-- RESTOCK --}}
                            <a href="{{ route('admin.bahan.restockForm', $b) }}"
                            class="text-green-600 hover:underline">
                                Restock
                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('admin.bahan.edit', $b) }}"
                            class="text-indigo-600 hover:underline">
                                Edit
                            </a>

                            {{-- HAPUS --}}
                            <form action="{{ route('admin.bahan.destroy', $b) }}"
                                method="POST"
                                class="inline"
                                onsubmit="return confirm('Yakin hapus bahan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </x-card>
    </x-admin-layout>
