<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Login Supervisi - {{ strtoupper($type) }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#4F46E5">
  <script src="/sw.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            /* Menangani Safe Area untuk iPhone/Android modern */
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
        }

        .desktop-blocker { display: none; }

        @media (min-width: 1024px) {
            .desktop-blocker {
                display: flex;
                position: fixed;
                inset: 0;
                background: white;
                z-index: 9999;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .mobile-content { display: none; }
        }

        .gradient-bg {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        }

        /* Perbaikan: Menggunakan relative agar tidak 'balapan' dengan elemen lain */
        .header-section {
            height: 260px;
            width: 100%;
            border-bottom-left-radius: 3.5rem;
            border-bottom-right-radius: 3.5rem;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .input-animated:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.1);
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden">

    <div class="desktop-blocker p-8 text-center">
        <div class="bg-indigo-50 p-6 rounded-3xl border border-indigo-100">
            <i data-lucide="smartphone" class="w-16 h-16 text-indigo-600 mx-auto mb-4"></i>
            <h2 class="text-xl font-bold text-gray-800">Gunakan Smartphone</h2>
            <p class="text-gray-600 mt-2 text-sm max-w-xs">Halaman login supervisi hanya dapat diakses melalui perangkat mobile.</p>
        </div>
    </div>

    <div class="mobile-content min-h-screen relative flex flex-col">
        <div class="header-section gradient-bg shadow-lg"></div>

        <main class="relative z-10 flex-1 flex flex-col items-center justify-center px-6 py-12">
            
            <div class="text-center mb-10 text-white w-full">
                <div class="bg-white/20 w-20 h-20 rounded-3xl backdrop-blur-md flex items-center justify-center mx-auto mb-4 shadow-xl border border-white/30">
                    @if($type === 'it')
                        <i data-lucide="monitor" class="w-10 h-10 text-white"></i>
                    @elseif($type === 'alkes')
                        <i data-lucide="stethoscope" class="w-10 h-10 text-white"></i>
                    @else
                        <i data-lucide="home" class="w-10 h-10 text-white"></i>
                    @endif
                </div>
                <h1 class="text-2xl font-bold tracking-tight">Login Supervisi</h1>
                <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/20 mt-3">
                    <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-indigo-50">Inventory {{ $type }}</span>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] p-8 shadow-2xl border border-gray-100 w-full max-w-sm">
                <form method="POST" action="{{ route('login', ['type' => $type]) }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email RS</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="input-animated w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:outline-none focus:border-indigo-500 transition-all duration-300"
                                placeholder="nama@paramedika.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </span>
                            <input type="password" name="password" required
                                class="input-animated w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:outline-none focus:border-indigo-500 transition-all duration-300"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full gradient-bg text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-200 active:scale-[0.96] transition-all flex items-center justify-center gap-3">
                        <span>Akses Sistem</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}" class="text-gray-400 text-xs font-semibold hover:text-indigo-600 flex items-center justify-center gap-1 opacity-70">
                        <i data-lucide="chevron-left" class="w-3 h-3"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </main>

        <footer class="pb-10 pt-4 text-center">
            <p class="text-[9px] text-gray-300 font-bold uppercase tracking-[0.3em]">RSU Mitra Paramedika &copy; 2026</p>
        </footer>
    </div>

    <script>
    let deferredPrompt;

    // 1. Tangkap event instalasi
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        
        // Munculkan Banner Kustom setelah 3 detik
        setTimeout(() => {
            const banner = document.getElementById('install-banner');
            if (banner) banner.classList.remove('hidden');
        }, 3000);
    });

    // 2. Fungsi saat tombol 'Instal Sekarang' diklik
    async function triggerInstall() {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            console.log(`User response: ${outcome}`);
            deferredPrompt = null;
            document.getElementById('install-banner').classList.add('hidden');
        }
    }
</script>

<div id="install-banner" class="hidden fixed bottom-6 left-6 right-6 z-[100] animate-bounce">
    <div class="bg-indigo-600 text-white p-4 rounded-2xl shadow-2xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-white/20 p-2 rounded-lg">
                <i data-lucide="download-cloud" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-xs font-bold font-sans">Instal Aplikasi Supervisi</p>
                <p class="text-[10px] opacity-80">Akses lebih cepat & hemat kuota</p>
            </div>
        </div>
        <button onclick="triggerInstall()" class="bg-white text-indigo-600 px-4 py-2 rounded-xl text-xs font-bold shadow-sm active:scale-90 transition-transform">
            Instal
        </button>
    </div>
</div>

  <script>
    // Inisialisasi Icon Lucide
    lucide.createIcons();

    // Script tambahan untuk mematikan akses jika User Agent bukan Mobile
    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      // Opsional: Bisa ditambahkan logika redirect atau custom blocking di sini
      console.log("Akses Desktop Terdeteksi");
    }
  </script>
</body>
</html>