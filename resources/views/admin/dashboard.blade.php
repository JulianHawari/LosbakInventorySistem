<x-admin-layout title="Dashboard" header="Dashboard">

    {{-- KARTU RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <x-card>
            <div class="text-slate-500 text-sm">Total Produksi</div>
            <div class="text-2xl font-bold">
                {{ $totalProduksi }}
            </div>
        </x-card>

        <x-card>
            <div class="text-slate-500 text-sm">Produksi Aktif</div>
            <div class="text-2xl font-bold text-yellow-600">
                {{ $produksiAktif }}
            </div>
        </x-card>

        <x-card>
            <div class="text-slate-500 text-sm">Jenis Bahan</div>
            <div class="text-2xl font-bold text-green-600">
                {{ $jumlahBahan }}
            </div>
        </x-card>

        <x-card>
            <div class="text-slate-500 text-sm">Template</div>
            <div class="text-2xl font-bold text-blue-600">
                {{ $jumlahTemplate }}
            </div>
        </x-card>
    </div>
            @if($stokMenipis->count())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                <div class="font-semibold text-red-700 mb-2">
                    ⚠️ Stok Hampir Habis
                </div>

                <ul class="text-sm text-red-600 list-disc pl-5">
                    @foreach($stokMenipis as $b)
                        <li>
                            {{ $b->nama_bahan }}
                            (stok {{ $b->stok }} {{ $b->satuan }})
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- PRODUKSI TERAKHIR --}}
        <x-card>
            <h3 class="font-semibold mb-4">Produksi Terakhir</h3>

            @forelse($produksiTerakhir as $p)
                <div class="flex justify-between border-b py-2 text-sm">
                    <div>
                        {{ $p->template?->nama_template ?? 'Custom' }}
                        <span class="text-slate-500">
                            ({{ $p->tanggal }})
                        </span>
                    </div>

                    <span class="capitalize
                        {{ $p->status === 'selesai'
                            ? 'text-green-600'
                            : 'text-yellow-600' }}">
                        {{ $p->status }}
                    </span>
                </div>
            @empty
                <div class="text-slate-500 text-sm">
                    Belum ada data
                </div>
            @endforelse
        </x-card>

        {{-- BAHAN HAMPIR HABIS --}}
        <x-card>
            <h3 class="font-semibold mb-4">Bahan Hampir Habis</h3>

            @forelse($bahanHampirHabis as $b)
                <div class="flex justify-between border-b py-2 text-sm">
                    <div>{{ $b->nama_bahan }}</div>
                    <div class="text-red-600 font-semibold">
                        {{ $b->stok }}
                    </div>
                </div>
            @empty
                <div class="text-slate-500 text-sm">
                    Belum ada data
                </div>
            @endforelse
        </x-card>

    </div>

</x-admin-layout>
