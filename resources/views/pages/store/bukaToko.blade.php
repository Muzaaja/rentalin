<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buka Toko - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito+Sans:wght@800&family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        /* Modal */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.45); z-index: 999;
            align-items: center; justify-content: center;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: #fff; border-radius: 12px;
            padding: 28px 32px; width: 92%; max-width: 500px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.18);
            max-height: 75vh; display: flex; flex-direction: column;
        }

        /* Header modal */
        .modal-header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 20px;
        }
        .modal-header h2 { font-size: 18px; font-weight: 700; color: #1E1E1E; margin: 0; }
        .modal-close {
            background: none; border: none; font-size: 20px;
            cursor: pointer; color: #6B7280; line-height: 1;
            padding: 0 4px;
        }
        .modal-close:hover { color: #1E1E1E; }

        /* Scrollable body */
        .modal-body { overflow-y: auto; flex: 1; margin-bottom: 16px; max-height: 280px; }

        /* Info box Paylater */
        .info-box {
            background: #EFF6FF; border: 1px solid #BFDBFE;
            border-radius: 8px; padding: 16px; margin-bottom: 20px;
        }
        .info-box-title {
            display: flex; align-items: center; gap: 8px;
            font-weight: 700; font-size: 14px; color: #1D4ED8; margin-bottom: 8px;
        }
        .info-box-desc { font-size: 13px; color: #1E40AF; margin-bottom: 10px; }
        .info-box ul { list-style: none !important; padding: 0 !important; margin: 0; }
        .info-box ul li { font-size: 12px; color: #1E40AF; margin-bottom: 4px; padding-left: 0 !important; }
        .info-box ul li::before { content: "• "; }

        /* Syarat sections */
        .syarat-section { margin-bottom: 16px; }
        .syarat-section h3 { font-size: 12px; font-weight: 700; color: #374151; letter-spacing: .04em; margin: 0 0 6px; text-transform: uppercase; }
        .syarat-section p { font-size: 13px; color: #4B5563; line-height: 1.6; margin: 0; }

        /* Checkbox */
        .modal-checkbox {
            display: flex; align-items: center; gap: 10px;
            font-size: 13px; color: #374151; margin-bottom: 20px;
            padding-top: 12px; border-top: 1px solid #E5E7EB;
        }
        .modal-checkbox input[type=checkbox] { width: 16px; height: 16px; cursor: pointer; flex-shrink: 0; accent-color: #34699A; }
        .modal-checkbox a { color: #34699A; font-weight: 600; text-decoration: none; }

        /* Buttons */
        .modal-actions { display: flex; gap: 12px; }
        .btn-batal {
            flex: 1; padding: 13px; border-radius: 8px;
            border: 1.5px solid #D1D5DB; background: #fff;
            font-size: 14px; font-weight: 600; color: #374151;
            cursor: pointer; font-family: inherit;
        }
        .btn-batal:hover { background: #F3F4F6; }
        .btn-setuju {
            flex: 1; padding: 13px; border-radius: 8px;
            border: none; background: #34699A; color: #fff;
            font-size: 14px; font-weight: 600; cursor: pointer;
            font-family: inherit; transition: background .2s;
            opacity: 0.5; pointer-events: none;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; text-align: center;
        }
        
        .btn-setuju.enabled { opacity: 1; pointer-events: auto; }
        .btn-setuju.enabled:hover { background: #2b5a87; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    {{-- Modal Syarat & Ketentuan --}}
    <div class="modal-overlay" id="modalSyarat">
        <div class="modal-box">

            <div class="modal-header">
                <h2>Syarat & Ketentuan Pembukaan Toko</h2>
                <button class="modal-close" onclick="tutupModal()">✕</button>
            </div>

            <div class="modal-body">

                {{-- Info Paylater --}}
                <div class="info-box">
                    <div class="info-box-title">
                        <span>ℹ️</span> Informasi Penting: Rentalin Paylater
                    </div>
                    <p class="info-box-desc">
                        Layanan Rentalin Paylater adalah fitur WAJIB yang akan otomatis aktif untuk seluruh toko baru di platform kami.
                    </p>
                    <ul>
                        <li>Meningkatkan potensi transaksi dengan opsi cicilan bagi penyewa.</li>
                        <li>Pencairan dana ke penjual tetap dilakukan secara penuh setelah transaksi selesai.</li>
                        <li>Seller tidak dikenakan biaya tambahan untuk aktivasi fitur ini.</li>
                    </ul>
                </div>

                {{-- Syarat 1 --}}
                <div class="syarat-section">
                    <h3>1. Verifikasi Identitas</h3>
                    <p>Penjual wajib mengunggah dokumen identitas resmi (KTP/Passport) yang valid. Seluruh informasi yang diberikan harus akurat dan sesuai dengan identitas asli untuk menjamin keamanan transaksi di ekosistem Rentalin.</p>
                </div>

                {{-- Syarat 2 --}}
                <div class="syarat-section">
                    <h3>2. Kepatuhan Layanan</h3>
                    <p>Setiap mitra penjual setuju untuk mematuhi standar pelayanan kami, termasuk namun tidak terbatas pada ketepatan waktu pengiriman, kualitas unit rental, dan kejujuran dalam deskripsi produk. Pelanggaran terhadap standar ini dapat mengakibatkan penangguhan akun secara permanen.</p>
                </div>

                {{-- Syarat 3 --}}
                <div class="syarat-section">
                    <h3>3. Keamanan & Privasi</h3>
                    <p>Rentalin berkomitmen untuk melindungi data pribadi Anda. Dengan melanjutkan, Anda menyetujui Kebijakan Privasi kami dan penggunaan data Anda untuk keperluan operasional toko dan verifikasi transaksi.</p>
                </div>

            </div>

            {{-- Checkbox --}}
            <div class="modal-checkbox">
                <input type="checkbox" id="checkSyarat" onchange="toggleSetuju(this)">
                <label for="checkSyarat">
                    Saya setuju dengan <a href="#">Syarat & Ketentuan</a> yang berlaku.
                </label>
            </div>

            {{-- Tombol --}}
            <div class="modal-actions">
                <button class="btn-batal" onclick="tutupModal()">Batal</button>
                <a id="btnSetuju" href="{{ route('store.step1Toko') }}" class="btn-setuju">
                    Setuju & Lanjutkan
                </a>
            </div>

        </div>
    </div>

    <main class="page-container" style="display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:70vh; text-align:center; padding: 40px 20px;">

        <a href="{{ url()->previous() }}" class="back-btn" style="position:absolute; top:100px; left:40px;">←</a>

        {{-- Ilustrasi --}}
        <div style="margin-bottom: 32px;">
            <img src="{{ asset('assets/img/ilustrasi_buka_toko.png') }}"
                 alt="Buka Toko"
                 style="max-width:380px; width:100%;"
                 onerror="this.style.display='none'">
        </div>

        <h1 style="font-size: 2rem; font-weight: 700; color: #1e1e2e; margin-bottom: 12px;">
            Mulai sewakan barangmu
        </h1>

        <p style="color: #6b7280; font-size: 1rem; max-width: 480px; margin-bottom: 40px;">
            Buka toko gratis dan mulai dapatkan penghasilan dari barang yang tidak terpakai
        </p>

        {{-- Tombol Buka Toko → buka modal dulu --}}
        <button onclick="bukaModal()"
           style="display:inline-flex; align-items:center; gap:10px;
                  background:#34699A; color:#fff; padding:16px 40px;
                  border-radius:8px; font-size:1.1rem; font-weight:600;
                  border:none; cursor:pointer; font-family:inherit;
                  transition:background 0.2s;">
            Buka Toko &nbsp;→
        </button>

    </main>

    @include('layouts.partials.footer')

    <script>
        function bukaModal() {
            document.getElementById('checkSyarat').checked = false;
            document.getElementById('btnSetuju').classList.remove('enabled');
            document.getElementById('modalSyarat').classList.add('show');
        }
        function tutupModal() {
            document.getElementById('modalSyarat').classList.remove('show');
        }
        function toggleSetuju(checkbox) {
            const btn = document.getElementById('btnSetuju');
            if (checkbox.checked) {
                btn.classList.add('enabled');
            } else {
                btn.classList.remove('enabled');
            }
        }
        // Tutup modal kalau klik di luar
        document.getElementById('modalSyarat').addEventListener('click', function(e) {
            if (e.target === this) tutupModal();
        });
    </script>

</body>
</html>