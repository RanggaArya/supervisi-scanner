<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Menu - {{ strtoupper($inventoryType) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
        }

        .premium-gradient {
            background: radial-gradient(circle at top right, #4f46e5, #0f172a);
        }
    </style>
</head>

<body class="antialiased min-h-screen flex flex-col">
    <header class="premium-gradient pt-12 pb-10 px-8 rounded-b-[3rem] shadow-2xl mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-white font-extrabold text-2xl uppercase italic">RSU Mitra</h1>
                <p class="text-indigo-300 text-xs font-bold uppercase tracking-widest mt-1">{{ $inventoryType }} SYSTEM
                </p>
            </div>
            <div class="text-right">
                <p class="text-[10px] text-slate-400 font-bold uppercase">Welcome</p>
                <p class="text-white font-bold">{{ $userName }}</p>
            </div>
        </div>
    </header>

    <main class="flex-1 px-6 space-y-4">
        <a href="{{ route('set.mode', 'supervisi') }}"
            class="group block relative overflow-hidden bg-slate-800 rounded-3xl p-6 border border-white/5 active:scale-95 transition-all">
            <div
                class="absolute inset-0 bg-gradient-to-r from-indigo-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
            </div>
            <div class="relative flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-indigo-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                    <i data-lucide="clipboard-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white uppercase tracking-tight">Supervisi</h3>
                    <p class="text-xs text-slate-400">Scan & Input Log Kondisi</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-slate-500 ml-auto"></i>
            </div>
        </a>

        <a href="{{ route('set.mode', 'maintenance') }}"
            class="group block relative overflow-hidden bg-slate-800 rounded-3xl p-6 border border-white/5 active:scale-95 transition-all">
            <div
                class="absolute inset-0 bg-gradient-to-r from-emerald-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
            </div>
            <div class="relative flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                    <i data-lucide="wrench" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white uppercase tracking-tight">Maintenance</h3>
                    <p class="text-xs text-slate-400">Redirect ke Web Maintenance</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-slate-500 ml-auto"></i>
            </div>
        </a>

        <a href="{{ route('set.mode', 'mutasi') }}"
            class="group block relative overflow-hidden bg-slate-800 rounded-3xl p-6 border border-white/5 active:scale-95 transition-all">
            <div
                class="absolute inset-0 bg-gradient-to-r from-amber-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
            </div>
            <div class="relative flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-500 flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                    <i data-lucide="arrow-left-right" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white uppercase tracking-tight">Mutasi</h3>
                    <p class="text-xs text-slate-400">Redirect ke Web Mutasi</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-slate-500 ml-auto"></i>
            </div>
        </a>
    </main>

    <div class="p-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full bg-red-500/10 border border-red-500/20 py-4 rounded-2xl text-red-400 text-xs font-black uppercase flex items-center justify-center gap-2 active:scale-95 transition-all">
                LOGOUT <i data-lucide="log-out" class="w-4 h-4"></i>
            </button>
        </form>
    </div>

    <script> lucide.createIcons(); </script>
</body>

</html>