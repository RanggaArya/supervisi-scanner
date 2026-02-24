<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Supervisi - {{ strtoupper($inventoryType) }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}?v=2">
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=2">
    <meta name="theme-color" content="#4F46E5">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
            color: #f8fafc;
        }

        .premium-gradient {
            background: radial-gradient(circle at top right, #4f46e5, #0f172a);
        }

        #reader {
            border: none !important;
            border-radius: 3rem;
            overflow: hidden;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.8);
        }

        #reader__dashboard {
            display: none !important;
        }

        #reader video {
            object-fit: cover !important;
            border-radius: 3rem;
            transform: scale(1.05);
        }

        .scan-glow-frame {
            position: absolute;
            inset: -4px;
            border: 4px solid transparent;
            background: linear-gradient(135deg, #6366f1, #a855f7) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            border-radius: 3.8rem;
            animation: border-glow 2s infinite;
            z-index: 20;
        }

        @keyframes border-glow {

            0%,
            100% {
                opacity: 0.3;
                filter: blur(4px);
            }

            50% {
                opacity: 1;
                filter: blur(1px);
            }
        }

        .bottom-sheet {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(30px) saturate(200%);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.5s cubic-bezier(0.32, 0.72, 0, 1);
            transform: translateY(100%);
        }

        .modal.active .bottom-sheet {
            transform: translateY(0);
        }

        /* MODIFIKASI: Note Sheet dengan deteksi Keyboard Fokus */
        #noteSheet {
            transition: transform 0.4s cubic-bezier(0.32, 0.72, 0, 1), bottom 0.4s ease;
        }

        #noteSheet.active {
            transform: translateY(0);
        }

        /* Menaikkan posisi modal saat input fokus agar tidak tertutup keyboard */
        #noteModal:focus-within #noteSheet {
            bottom: 20%;
            /* Menaikkan posisi ke tengah layar saat mengetik */
        }

        .info-pill {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="antialiased overflow-hidden">

    <div class="mobile-content min-h-screen flex flex-col relative">
        <header class="premium-gradient pt-12 pb-24 px-8 rounded-b-[4rem] relative overflow-hidden shadow-2xl">
            <div class="flex justify-between items-start relative z-10">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}"
                        class="bg-white/10 p-2 rounded-xl text-white hover:bg-white/20 transition">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div class="w-14 h-14 bg-white p-0.5 rounded-2xl shadow-2xl flex-shrink-0">
                        <img src="{{ asset('logo.png') }}?v=2" alt="Logo"
                            class="w-full h-full object-contain rounded-xl">
                    </div>
                    <div>
                        <h1 class="text-white font-extrabold text-lg leading-tight uppercase tracking-tighter italic">
                            RSU Mitra</h1>
                        <h1
                            class="text-indigo-400 font-extrabold text-lg leading-tight uppercase tracking-tighter italic">
                            Paramedika</h1>
                        <div
                            class="mt-2 inline-flex items-center bg-indigo-500 text-white text-[9px] font-black px-2.5 py-1 rounded-lg tracking-widest uppercase shadow-lg shadow-indigo-500/20">
                            {{ $inventoryType }} ACCESS
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-3 text-right">
                    <div class="flex flex-col items-end">
                        <span
                            class="text-slate-400 text-[10px] font-bold uppercase tracking-wider leading-none mb-1">Supervisor</span>
                        <span
                            class="text-white text-xs font-extrabold uppercase truncate max-w-[100px]">{{ $userName }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-red-500/10 border border-red-500/20 px-4 py-2 rounded-xl text-red-400 text-[10px] font-black uppercase flex items-center gap-2 active:scale-95 transition-all">
                            LOGOUT <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 px-8 -mt-14 relative z-20">
            <div class="relative group">
                <div class="scan-glow-frame"></div>
                <div
                    class="bg-slate-900 rounded-[4rem] p-5 shadow-[0_40px_80px_-15px_rgba(0,0,0,0.8)] ring-1 ring-white/10">
                    <div id="reader" class="w-full aspect-square bg-black shadow-inner"></div>
                    <div class="text-center pt-8 pb-4">
                        <div class="flex justify-center gap-1.5 mb-6">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 shadow-[0_0_10px_#6366f1]"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-300"></span>
                        </div>
                        <h3 class="text-slate-200 font-extrabold text-xs uppercase tracking-[0.4em] mb-2 leading-none">
                            Scanning Engine</h3>
                        <p class="text-slate-500 text-[9px] font-bold px-8 leading-relaxed uppercase tracking-widest">
                            Arahkan label aset tepat ke pusat sensor
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-2 gap-4">
                <div class="info-pill p-4 rounded-3xl flex flex-col gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-indigo-400"></i>
                    <div>
                        <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Server Time</p>
                        <p class="text-[11px] font-bold text-white leading-none mt-1">{{ date('H:i') }} WIB</p>
                    </div>
                </div>
                <div class="info-pill p-4 rounded-3xl flex flex-col gap-2">
                    <i data-lucide="shield-check" class="w-5 h-5 text-emerald-400"></i>
                    <div>
                        <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest">System Status</p>
                        <p
                            class="text-[11px] font-bold text-emerald-400 uppercase tracking-tighter italic leading-none mt-1">
                            Online</p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="py-12 text-center">
            <p class="text-[9px] text-slate-600 font-black uppercase tracking-[0.6em]">RSU MITRA PARAMEDIKA &copy; 2026
            </p>
        </footer>
    </div>

    <div id="detailModal" class="modal fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md" id="modalOverlay"></div>
        <div
            class="bottom-sheet absolute bottom-0 left-0 right-0 rounded-t-[4rem] max-h-[85vh] flex flex-col shadow-2xl">
            <div class="w-12 h-1 bg-white/10 rounded-full mx-auto my-6"></div>

            <div class="px-10 pb-6">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/40 text-white">
                        <i data-lucide="search" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-white tracking-tighter uppercase leading-none">Aset
                            Terdeteksi</h3>
                        <p class="text-[9px] font-black text-indigo-400 mt-2 tracking-widest uppercase italic">Database
                            Sync Active</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto px-10 pb-6 space-y-4" id="detailContent"></div>

            <div class="p-8 pb-12 flex gap-4">
                <button onclick="openNoteSheet()"
                    class="flex-1 bg-indigo-600 text-white font-black py-5 rounded-3xl shadow-xl shadow-indigo-600/30 active:scale-95 transition-all text-xs uppercase tracking-[0.2em]">
                    KONFIRMASI ASET
                </button>
                <button onclick="closeModal()"
                    class="w-16 h-16 bg-white/5 border border-white/10 rounded-3xl flex items-center justify-center text-slate-400 active:scale-90 transition-all">
                    <i data-lucide="x" class="w-6 h-6 text-white"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="noteModal" class="modal fixed inset-0 z-[110] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeNoteSheet()"></div>
        <div id="noteSheet"
            class="absolute bottom-0 left-0 right-0 bg-slate-900 rounded-t-[4rem] border-t border-white/10 p-10 shadow-2xl translate-y-full">
            <div class="w-12 h-1 bg-white/10 rounded-full mx-auto mb-8"></div>

            <div class="flex items-center gap-3 mb-6">
                <i data-lucide="pen-tool" class="w-5 h-5 text-indigo-400"></i>
                <h3 class="text-xl font-black text-white uppercase tracking-tighter leading-none">Catatan Fisik</h3>
            </div>

            <div class="relative mb-8">
                <textarea id="catatanInput"
                    class="w-full bg-white/5 border border-white/10 rounded-[2rem] p-6 text-white text-sm focus:outline-none focus:border-indigo-500 transition-all placeholder-slate-600 shadow-inner"
                    rows="3" placeholder="Tuliskan detail kondisi perangkat..."></textarea>
            </div>

            <div class="flex gap-4">
                <button onclick="supervisi()" id="finalBtn"
                    class="flex-1 bg-emerald-500 text-white font-black py-5 rounded-3xl shadow-xl shadow-emerald-500/20 active:scale-95 transition-all text-xs uppercase tracking-[0.2em]">
                    SIMPAN LOG
                </button>
                <button onclick="closeNoteSheet()"
                    class="w-16 h-16 bg-white/5 border border-white/10 rounded-3xl flex items-center justify-center text-slate-400">
                    <i data-lucide="arrow-down" class="w-6 h-6 text-white"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        let currentItem = null;
        let html5QrCode = null;
        let isProcessing = false;

        const scanMode = "{{ $scanMode }}"; // 'supervisi', 'maintenance', atau 'mutasi'

        function startScanner() {
            html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 20, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 };
            html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess)
                .catch(() => html5QrCode.start({ facingMode: "user" }, config, onScanSuccess));
        }

        function onScanSuccess(decodedText) {
            if (isProcessing) return;
            isProcessing = true;
            if (navigator.vibrate) navigator.vibrate(100);
            html5QrCode.pause();
            // LOGIC UTAMA: Cek Mode
            if (scanMode === 'supervisi') {
                // Mode lama: Fetch Data & Tampil Modal
                fetchItemDetail(decodedText);
            } else {
                // Mode Maintenance / Mutasi
                // Asumsi: QR Code berisi URL lengkap (contoh: https://siminta.rsumipayk.co.id/perangkat/1740)
                handleRedirectMode(decodedText);
            }
        }

        function handleRedirectMode(url) {
            // Validasi sederhana apakah ini URL
            try {
                // Cek apakah string diawali http/https
                if (url.startsWith('http')) {
                    // Tampilkan loading visual
                    document.getElementById('reader').innerHTML =
                        '<div class="flex flex-col items-center justify-center h-full text-white"><span class="w-8 h-8 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin mb-4"></span><span class="text-xs uppercase font-bold tracking-widest">Redirecting...</span></div>';

                    // Lakukan Redirect ke Project Web Inventaris Asli
                    window.location.href = url;
                } else {
                    // Jika QR cuma angka (bukan URL), kita bisa handle error atau coba construct URL manual jika perlu.
                    // Tapi sesuai permintaan "hasil scannernya masuk ke url itu aja", kita asumsi QR = URL.
                    alert('QR Code bukan URL valid: ' + url);
                    isProcessing = false;
                    html5QrCode.resume();
                }
            } catch (e) {
                alert('Gagal memproses URL');
                isProcessing = false;
                html5QrCode.resume();
            }
        }

        function fetchItemDetail(qrCode) {
            const modal = document.getElementById('detailModal');
            const overlay = document.getElementById('modalOverlay');
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.add('active'); overlay.classList.replace('opacity-0', 'opacity-100'); }, 50);

            document.getElementById('detailContent').innerHTML = '<p class="text-center py-10 text-slate-500 text-[10px] font-black uppercase tracking-[0.3em] animate-pulse">Syncing Database...</p>';

            fetch('{{ route("get.item") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ qr_code: qrCode })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        currentItem = data.data;
                        renderDetail(data.data);
                    } else {
                        alert('Label Tidak Terdaftar');
                        closeModal();
                    }
                })
                .catch(() => closeModal());
        }

        function renderDetail(item) {
            const container = document.getElementById('detailContent');
            const fields = [
                { label: 'No Inventaris', value: item.nomor_inventaris, icon: 'hash' },
                { label: 'Nama Perangkat', value: item.nama_perangkat, icon: 'monitor' },
                { label: 'Kondisi', value: item.nama_kondisi, icon: 'activity' },
                { label: 'Lokasi', value: item.nama_lokasi, icon: 'map-pin' }
            ];

            container.innerHTML = fields.map(f => `
                <div class="info-pill p-5 rounded-[2.5rem] flex items-center gap-5 ring-1 ring-white/5 shadow-inner">
                    <div class="w-11 h-11 rounded-2xl bg-white/5 flex items-center justify-center text-indigo-400">
                        <i data-lucide="${f.icon}" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">${f.label}</p>
                        <p class="text-[13px] font-extrabold text-slate-200 uppercase tracking-tighter italic leading-none">${f.value}</p>
                    </div>
                </div>
            `).join('');
            lucide.createIcons();
        }

        function openNoteSheet() {
            document.getElementById('noteModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('noteSheet').classList.add('active');
                document.getElementById('catatanInput').focus(); // Otomatis fokus saat terbuka
            }, 10);
        }

        function closeNoteSheet() {
            document.getElementById('noteSheet').classList.remove('active');
            setTimeout(() => document.getElementById('noteModal').classList.add('hidden'), 500);
        }

        function closeModal() {
            const modal = document.getElementById('detailModal');
            const overlay = document.getElementById('modalOverlay');
            modal.classList.remove('active');
            overlay.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); currentItem = null; isProcessing = false; if (html5QrCode) html5QrCode.resume(); }, 500);
        }

        function supervisi() {
            if (!currentItem) return;
            const ket = document.getElementById('catatanInput').value;
            const btn = document.getElementById('finalBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin"></span>';

            fetch('{{ route("supervisi") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ item_id: currentItem.id, keterangan: ket })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('catatanInput').value = '';
                        closeNoteSheet();
                        closeModal();
                    } else {
                        btn.disabled = false;
                        btn.innerHTML = 'SIMPAN LOG';
                    }
                });
        }

        window.addEventListener('load', () => setTimeout(startScanner, 800));
    </script>
</body>

</html>