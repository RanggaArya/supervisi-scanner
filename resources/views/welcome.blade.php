<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Sistem Inventaris - RSU Mitra Paramedika</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}?v=2">
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=2">
    <meta name="theme-color" content="#4F46E5">
    <script src="/sw.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            -webkit-tap-highlight-color: transparent;
        }

        .mobile-only-overlay { display: none; }

        /* Deteksi Layar Desktop */
        @media (min-width: 1024px) {
            .mobile-only-overlay {
                display: flex;
                position: fixed;
                inset: 0;
                background: #fff;
                z-index: 9999;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 2rem;
            }
            .main-content { display: none; }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-primary {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        }

        /* Animasi masuk untuk logo */
        .logo-pulse {
            animation: pulse-border 2s infinite;
        }

        @keyframes pulse-border {
            0% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(255, 255, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
        }
    </style>
</head>

<body class="antialiased overflow-x-hidden">

    <div class="mobile-only-overlay">
        <div class="bg-indigo-50 p-8 rounded-[2.5rem] border border-indigo-100 max-w-sm">
            <i data-lucide="smartphone" class="w-16 h-16 text-indigo-600 mx-auto mb-4"></i>
            <h2 class="text-xl font-bold text-gray-800 uppercase tracking-tight">Akses Terbatas</h2>
            <p class="text-gray-600 mt-2 text-sm leading-relaxed">
                Sistem Supervisi <b>RSU Mitra Paramedika</b> dirancang khusus untuk penggunaan lapangan melalui perangkat mobile.
            </p>
        </div>
    </div>

    <main class="main-content min-h-screen pb-12">
        <div class="gradient-primary pt-14 pb-28 px-6 rounded-b-[3.5rem] shadow-2xl relative overflow-hidden">
            <div class="absolute top-[-10%] right-[-10%] w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            
            <div class="flex flex-col items-center text-center text-white relative z-10">
                <div class="w-20 h-20 bg-white p-1 rounded-2xl mb-5 shadow-2xl logo-pulse">
                    <img src="{{ asset('logo.png') }}?v=2" alt="Logo RSU" class="w-full h-full object-contain rounded-xl">
                </div>
                
                <h1 class="text-2xl font-extrabold tracking-tight leading-tight">
                    RSU MITRA PARAMEDIKA
                </h1>
                <p class="text-indigo-100 text-[11px] font-bold uppercase tracking-[0.3em] mt-2 opacity-80">
                    Sistem Supervisi Inventaris
                </p>
            </div>
        </div>

        <div class="px-6 -mt-16">
            <div class="glass-card rounded-[2.5rem] p-7 shadow-2xl border border-white">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-indigo-600/10 p-2 rounded-lg">
                        <i data-lucide="layout-grid" class="w-5 h-5 text-indigo-600"></i>
                    </div>
                    <h3 class="text-gray-800 font-bold text-lg leading-none">Pilih Kategori</h3>
                </div>

                @if(session('error'))
                <div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl flex items-center gap-3 animate-shake">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i>
                    <span class="text-red-700 text-xs font-semibold">{{ session('error') }}</span>
                </div>
                @endif

                <div class="space-y-4">
                    <a href="{{ route('login.form', ['type' => 'it']) }}"
                        class="group flex items-center p-4 rounded-3xl bg-slate-50 border border-slate-100 hover:border-indigo-300 transition-all active:scale-95 shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 mr-4 shadow-inner">
                            <i data-lucide="monitor"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 text-sm italic tracking-tight uppercase">Inventory IT</h4>
                            <p class="text-gray-400 text-[10px] font-medium tracking-wide">Aset Komputer & Network</p>
                        </div>
                        <div class="bg-white p-2 rounded-xl shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:text-white"></i>
                        </div>
                    </a>

                    <a href="{{ route('login.form', ['type' => 'alkes']) }}"
                        class="group flex items-center p-4 rounded-3xl bg-slate-50 border border-slate-100 hover:border-indigo-300 transition-all active:scale-95 shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 mr-4 shadow-inner">
                            <i data-lucide="stethoscope"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 text-sm italic tracking-tight uppercase">Inventory Alkes</h4>
                            <p class="text-gray-400 text-[10px] font-medium tracking-wide">Peralatan Medis RS</p>
                        </div>
                        <div class="bg-white p-2 rounded-xl shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:text-white"></i>
                        </div>
                    </a>

                    <a href="{{ route('login.form', ['type' => 'rt']) }}"
                        class="group flex items-center p-4 rounded-3xl bg-slate-50 border border-slate-100 hover:border-indigo-300 transition-all active:scale-95 shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-600 mr-4 shadow-inner">
                            <i data-lucide="home"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 text-sm italic tracking-tight uppercase">Inventory RT</h4>
                            <p class="text-gray-400 text-[10px] font-medium tracking-wide">Fasilitas Rumah Tangga</p>
                        </div>
                        <div class="bg-white p-2 rounded-xl shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:text-white"></i>
                        </div>
                    </a>
                </div>
            </div>

            <div class="mt-10 text-center">
                <p class="text-gray-400 text-[9px] uppercase tracking-[0.4em] font-black">
                    &copy; 2026 RSU MITRA PARAMEDIKA
                </p>
                <p class="text-gray-300 text-[8px] mt-1 font-bold">DIGITAL TRANSFORMATION TEAM</p>
            </div>
        </div>
    </main>

    <div id="install-banner" class="hidden fixed bottom-6 left-6 right-6 z-[100] animate-bounce">
        <div class="gradient-primary text-white p-4 rounded-3xl shadow-2xl flex items-center justify-between border border-white/20">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-xl">
                    <i data-lucide="download-cloud" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-xs font-bold font-sans">Pasang di Layar Utama</p>
                    <p class="text-[9px] opacity-80 uppercase tracking-tighter">Akses Instan & Penggunaan Offline</p>
                </div>
            </div>
            <button onclick="triggerInstall()" class="bg-white text-indigo-600 px-5 py-2.5 rounded-2xl text-[11px] font-black shadow-lg active:scale-90 transition-transform uppercase">
                Pasang
            </button>
        </div>
    </div>

    <script>
        // Inisialisasi Lucide
        lucide.createIcons();

        // PWA Install Logic
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            setTimeout(() => {
                const banner = document.getElementById('install-banner');
                if (banner) banner.classList.remove('hidden');
            }, 3000);
        });

        async function triggerInstall() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                deferredPrompt = null;
                document.getElementById('install-banner').classList.add('hidden');
            }
        }

        // Desktop Blocker Logic
        if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            console.log("Desktop detected - restriction active.");
        }
    </script>
</body>
</html>