<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Admin' }} | Losbak</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-100">
<div class="flex h-screen overflow-hidden">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="w-64 bg-slate-900 text-slate-100 flex flex-col">

        {{-- LOGO --}}
        <div class="px-6 py-4 text-2xl font-bold border-b border-slate-700">
            Sumber<span class="text-blue-400">Urip</span>
        </div>

        @php
            use App\Models\BahanBaku;

            $menu = [
                ['label'=>'Dashboard','route'=>'admin.dashboard'],
                ['label'=>'Produksi','route'=>'admin.produksi.index'],
                ['label'=>'Bahan Baku','route'=>'admin.bahan.index'],
                ['label'=>'Template','route'=>'admin.template.index'],
            ];

            // hitung stok menipis
            $stokWarning = BahanBaku::whereColumn('stok','<=','min_stok')->count();
        @endphp

        {{-- MENU --}}
        <nav class="flex-1 px-4 py-6 space-y-2 text-sm">
            @foreach($menu as $m)
                <a href="{{ route($m['route']) }}"
                   class="flex justify-between items-center px-4 py-2 rounded-lg transition
                   {{ request()->routeIs(str_replace('.index','*',$m['route']))
                        ? 'bg-blue-600 text-white'
                        : 'hover:bg-slate-800' }}">

                    <span>{{ $m['label'] }}</span>

                    {{-- BADGE KHUSUS BAHAN BAKU --}}
                    @if($m['route'] === 'admin.bahan.index' && $stokWarning > 0)
                        <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                            {{ $stokWarning }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- USER --}}
        <div class="px-6 py-4 border-t border-slate-700 text-sm">
            <div class="font-semibold">{{ auth()->user()->name }}</div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-400 hover:underline mt-1">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ================= CONTENT ================= --}}
    <main class="flex-1 overflow-y-auto">

        {{-- HEADER --}}
        <header class="bg-white px-8 py-5 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-800">
                {{ $header ?? 'Dashboard' }}
            </h1>
        </header>

        {{-- NOTIF GLOBAL --}}
        @if(session('warning'))
            <div class="mx-8 mt-6 bg-yellow-50 border border-yellow-300 text-yellow-800 p-4 rounded-lg">
                ⚠️ {{ session('warning') }}
            </div>
        @endif

        {{-- PAGE --}}
        <section class="p-8">
            {{ $slot }}
        </section>
    </main>

</div>
</body>
</html>
