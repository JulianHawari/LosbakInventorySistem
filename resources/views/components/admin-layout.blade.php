<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Admin' }} | Sumber Urip</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>


<body class="bg-slate-100 font-sans">
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
            [
                'label' => 'Dashboard',
                'route' => 'admin.dashboard',
                'icon' => 'dashboard'
            ],
            [
                'label' => 'Produksi',
                'route' => 'admin.produksi.index',
                'icon' => 'produksi'
            ],
            [
                'label' => 'Bahan Baku',
                'route' => 'admin.bahan.index',
                'icon' => 'bahan'
            ],
            [
                'label' => 'Template',
                'route' => 'admin.template.index',
                'icon' => 'template'
            ],
        ];
            // hitung stok menipis
            $stokWarning = BahanBaku::whereColumn('stok','<=','min_stok')->count();
        @endphp

        {{-- MENU --}}
        <nav class="flex-1 px-4 py-6 space-y-2 text-sm">
        @foreach($menu as $m)
        <a href="{{ route($m['route']) }}"
        class="flex items-center justify-between px-4 py-2 rounded-lg transition
        {{ request()->routeIs(str_replace('.index','*',$m['route']))
                ? 'bg-blue-600 text-white'
                : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            {{-- KIRI: ICON + LABEL --}}
            <div class="flex items-center gap-3">
                {{-- ICON --}}
                <span class="w-5 h-5">
                    @switch($m['route'])

                        @case('admin.dashboard')
                        {{-- Dashboard --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.5h8.25V3H3v10.5zm9.75 7.5H21v-6.75h-8.25V21zm0-18v8.25H21V3h-8.25zM3 21h8.25v-6.75H3V21z"/>
                        </svg>
                        @break

                        @case('admin.produksi.index')
                        {{-- Produksi --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 21h18M4 21V9l6 3V9l7 4v8"/>
                        </svg>
                        @break

                        @case('admin.bahan.index')
                        {{-- Bahan Baku --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 7.5L12 12l-8.25-4.5M12 12v9"/>
                        </svg>
                        @break

                        @case('admin.template.index')
                        {{-- Template --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6M5.25 4.5h8.69L18.75 9v10.5a2.25 2.25 0 01-2.25 2.25h-11A2.25 2.25 0 013.25 19.5V6.75A2.25 2.25 0 015.5 4.5z"/>
                        </svg>
                        @break

                    @endswitch
                </span>

                {{-- LABEL --}}
                <span>{{ $m['label'] }}</span>
            </div>

            {{-- KANAN: BADGE STOK WARNING --}}
            @if($m['route'] === 'admin.bahan.index' && $stokWarning > 0)
                <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                    {{ $stokWarning }}
                </span>
            @endif
        </a>
        @endforeach

        </nav>
    </aside>

    {{-- ================= CONTENT ================= --}}
    <main class="flex-1 flex flex-col overflow-y-auto">

                {{-- HEADER --}}
        <header class="bg-white px-8 py-4 shadow-sm flex items-center justify-between">
            {{-- JUDUL --}}
            <h1 class="text-2xl font-bold text-slate-800">
                {{ $header ?? 'Dashboard' }}
            </h1>

            {{-- PROFILE DROPDOWN --}}
            <div class="relative">
                <button
                    onclick="toggleProfile()"
                    class="flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-slate-900"
                >
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    {{ auth()->user()->name }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div
                    id="profileDropdown"
                    class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border text-sm"
                >
                    <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 hover:bg-slate-100">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full text-left px-4 py-2 hover:bg-slate-100 text-red-600"
                        >
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>


        {{-- NOTIF GLOBAL --}}
        @if(session('warning'))
            <div class="mx-8 mt-6 bg-yellow-50 border border-yellow-300 text-yellow-800 p-4 rounded-lg">
                ⚠️ {{ session('warning') }}
            </div>
        @endif

            {{-- PAGE --}}
        <section class="p-8 flex-1">
            {{ $slot }}
        </section>

        {{-- FOOTER --}}
        <footer class="bg-white border-t text-center text-sm text-slate-500 py-3">
            © {{ date('Y') }} Losbak System BY RJA Corp. All rights reserved.
        </footer>
        
    </main>

</div>
        <script>
        function toggleProfile() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
        }
        </script>

</body>
</html>
