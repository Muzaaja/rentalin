<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Metode Pembayaran - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        body { background: #F5F7FA; font-family: 'Inter', sans-serif; }
        .page-wrap { width: 100%; max-width: 1289px; margin: 0 auto; padding: 28px 40px 60px; box-sizing: border-box; }
        .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .btn-back { display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .btn-back img { width: 36px; height: 36px; display: block; }
        .page-title { font-size: 20px; font-weight: 700; color: #1E1E1E; margin: 0; }

        .pengaturan-layout { display: grid; grid-template-columns: 260px 1fr; gap: 24px; align-items: start; }

        .sidebar { background: #fff; border-radius: 14px; box-shadow: 0 2px 20px rgba(0,0,0,0.07); overflow: hidden; }
        .sidebar-item { display: flex; align-items: center; gap: 12px; padding: 15px 20px; font-size: 14px; font-weight: 500; color: #374151; text-decoration: none; border-left: 3px solid transparent; transition: all 0.2s; }
        .sidebar-item:hover { background: #F9FAFB; color: #34699A; }
        .sidebar-item.active { background: #EFF6FF; color: #34699A; font-weight: 600; border-left-color: #34699A; }
        .sidebar-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        .content-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 20px rgba(0,0,0,0.07); padding: 32px; }
        .content-title { font-size: 18px; font-weight: 700; color: #1E1E1E; margin: 0 0 4px; }
        .content-subtitle { font-size: 13px; color: #6B7280; margin: 0 0 28px; }

        /* ── Payment sections ── */
        .payment-section { border: 1px solid #E5E7EB; border-radius: 12px; padding: 20px 24px; margin-bottom: 16px; }
        .payment-section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0; }
        .payment-section-info { display: flex; align-items: center; gap: 14px; }
        .payment-icon { width: 44px; height: 44px; border-radius: 10px; background: #F3F4F6; display: flex; align-items: center; justify-content: center; }
        .payment-icon svg { width: 22px; height: 22px; }
        .payment-name { font-size: 15px; font-weight: 700; color: #1E1E1E; margin-bottom: 2px; }
        .payment-desc { font-size: 13px; color: #6B7280; }

        .btn-ubah {
            background: #fff; color: #374151; font-family: 'Inter', sans-serif;
            font-size: 13px; font-weight: 500; padding: 8px 20px; border-radius: 8px;
            border: 1px solid #D1D5DB; cursor: pointer; transition: all 0.2s;
            text-decoration: none; display: inline-block;
        }
        .btn-ubah:hover { border-color: #34699A; color: #34699A; }

        .badge-aktif { display: inline-block; background: #DBEAFE; color: #1E40AF; font-size: 13px; font-weight: 600; padding: 6px 16px; border-radius: 20px; }

        /* ── Bank detail table ── */
        .bank-detail { margin-top: 16px; background: #F9FAFB; border-radius: 8px; padding: 16px 20px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; }
        .bank-col-label { font-size: 11px; font-weight: 600; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .bank-col-value { font-size: 14px; font-weight: 700; color: #1E1E1E; }

        /* ── Bantuan box ── */
        .bantuan-box { margin-top: 24px; background: #EFF6FF; border-radius: 12px; padding: 20px 24px; display: flex; align-items: flex-start; gap: 12px; }
        .bantuan-box svg { width: 20px; height: 20px; flex-shrink: 0; margin-top: 2px; }
        .bantuan-box h4 { font-size: 14px; font-weight: 700; color: #34699A; margin: 0 0 4px; }
        .bantuan-box p { font-size: 13px; color: #34699A; margin: 0; }
        .bantuan-box a { color: #34699A; font-weight: 600; }

        /* ── Modal Ubah Rekening ── */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: #fff; border-radius: 16px; padding: 36px 40px; width: 100%; max-width: 520px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
        .modal-title { font-size: 18px; font-weight: 700; color: #1E1E1E; margin: 0 0 4px; }
        .modal-subtitle { font-size: 13px; color: #6B7280; margin: 0 0 28px; }
        .form-group { margin-bottom: 20px; }
        .form-label { font-size: 14px; font-weight: 500; color: #374151; display: block; margin-bottom: 8px; }
        .form-input { width: 100%; box-sizing: border-box; border: 1px solid #D1D5DB; border-radius: 8px; padding: 12px 16px; font-size: 14px; color: #374151; font-family: inherit; outline: none; transition: border-color .2s, box-shadow .2s; }
        .form-input::placeholder { color: #9CA3AF; }
        .form-input:focus { border-color: #34699A; box-shadow: 0 0 0 3px rgba(52,105,154,.1); }
        .modal-footer { display: flex; justify-content: flex-end; gap: 12px; margin-top: 32px; }
        .btn-cancel { background: #fff; color: #374151; font-family: inherit; font-size: 14px; font-weight: 500; padding: 11px 24px; border-radius: 8px; border: 1px solid #D1D5DB; cursor: pointer; }
        .btn-simpan { background: #34699A; color: #fff; font-family: inherit; font-size: 14px; font-weight: 600; padding: 11px 24px; border-radius: 8px; border: none; cursor: pointer; transition: background .2s; }
        .btn-simpan:hover { background: #2b5a87; }
        
        /* ── Toast notif ── */
        .toast { position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%) translateY(20px); background: #1E1E1E; color: #fff; font-size: 13px; font-weight: 500; padding: 12px 24px; border-radius: 10px; opacity: 0; transition: opacity 0.3s, transform 0.3s; pointer-events: none; z-index: 9999; }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    @php
        // Mengambil data toko dari user yang sedang login
        $toko = auth()->user()->toko;
    @endphp

    <main class="page-wrap">

        <div class="page-header">
            <a href="{{ route('store.dashboardToko') }}" class="btn-back">
                <img src="{{ asset('assets/icons/arrow-left-circle.png') }}" alt="Kembali">
            </a>
            <h1 class="page-title">Pengaturan Toko</h1>
        </div>

        <div class="pengaturan-layout">

            {{-- Sidebar --}}
            <nav class="sidebar">
                <a href="{{ route('store.pengaturan') }}" class="sidebar-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Informasi Toko
                </a>
                <a href="{{ route('store.pengaturan.ulasan') }}" class="sidebar-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    Ulasan & Rating
                </a>
                <a href="{{ route('store.pengaturan.pembayaran') }}" class="sidebar-item active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="3"/><line x1="2" y1="10" x2="22" y2="10"/>
                    </svg>
                    Metode Pembayaran
                </a>
                <a href="{{ route('store.pengaturan.edukasi') }}" class="sidebar-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                    Pusat Edukasi
                </a>
            </nav>

            {{-- Konten Metode Pembayaran --}}
            <div class="content-card">
                <h2 class="content-title">Metode Pembayaran</h2>
                <p class="content-subtitle">Kelola cara Anda menerima pembayaran dari penyewa</p>

                {{-- Transfer Bank --}}
                <div class="payment-section">
                    <div class="payment-section-header">
                        <div class="payment-section-info">
                            <div class="payment-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                                    <line x1="3" y1="22" x2="21" y2="22"/>
                                    <line x1="6" y1="18" x2="6" y2="11"/>
                                    <line x1="10" y1="18" x2="10" y2="11"/>
                                    <line x1="14" y1="18" x2="14" y2="11"/>
                                    <line x1="18" y1="18" x2="18" y2="11"/>
                                    <polygon points="12 2 20 7 4 7"/>
                                </svg>
                            </div>
                            <div>
                                <div class="payment-name">Transfer Bank</div>
                                <div class="payment-desc">Rekening tujuan untuk penarikan saldo toko</div>
                            </div>
                        </div>
                        <button class="btn-ubah" onclick="openModal()">Ubah</button>
                    </div>
                    <div class="bank-detail">
                        <div>
                            <div class="bank-col-label">Bank</div>
                            <div class="bank-col-value" id="displayBank">{{ $toko->nama_bank }}</div>
                        </div>
                        <div>
                            <div class="bank-col-label">Nomor Rekening</div>
                            <div class="bank-col-value" id="displayRekening">{{ $toko->nomor_rekening }}</div>
                        </div>
                        <div>
                            <div class="bank-col-label">Nama Pemilik</div>
                            <div class="bank-col-value" id="displayPemilik">{{ $toko->nama_pemilik_rekening }}</div>
                        </div>
                    </div>
                </div>

                {{-- Rentalin Paylater --}}
                <div class="payment-section">
                    <div class="payment-section-header">
                        <div class="payment-section-info">
                            <div class="payment-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                                    <rect x="2" y="5" width="20" height="14" rx="3"/>
                                    <line x1="2" y1="10" x2="22" y2="10"/>
                                    <line x1="6" y1="15" x2="9" y2="15" stroke-linecap="round"/>
                                    <line x1="12" y1="15" x2="15" y2="15" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div>
                                <div class="payment-name">Rentalin Paylater</div>
                                <div class="payment-desc">Metode pembayaran cicilan untuk pelanggan Anda.</div>
                            </div>
                        </div>
                        <span class="badge-aktif">Aktif</span>
                    </div>
                </div>

                {{-- Bantuan --}}
                <div class="bantuan-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#34699A" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <circle cx="12" cy="16" r="1" fill="#34699A" stroke="none"/>
                    </svg>
                    <div>
                        <h4>Butuh bantuan?</h4>
                        <p>Gunakan <a href="{{ route('store.pengaturan.edukasi') }}">Pusat Edukasi</a> untuk mempelajari cara mengoptimalkan profil toko Anda agar lebih menarik bagi pembeli.</p>
                    </div>
                </div>

            </div>
        </div>

    </main>

    {{-- Modal Ubah Rekening Bank --}}
    <div class="modal-overlay" id="modalRekening">
        <div class="modal-box">
            <h2 class="modal-title">Ubah Rekening Bank</h2>
            <p class="modal-subtitle">Kelola cara Anda menerima pembayaran dari penyewa</p>

            <form id="formRekening" onsubmit="saveRekening(event)">
                <div class="form-group">
                    <label class="form-label">Nama Bank</label>
                    <input type="text" id="inputBank" class="form-input" value="{{ $toko->nama_bank }}" placeholder="Masukkan nama Bank" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Rekening</label>
                    <input type="text" id="inputRekening" class="form-input" value="{{ $toko->nomor_rekening }}" placeholder="Masukkan nomor rekening" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Pemilik Rekening</label>
                    <input type="text" id="inputPemilik" class="form-input" value="{{ $toko->nama_pemilik_rekening }}" placeholder="Sesuai dengan nama pada KTP" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-simpan" id="btnSimpanRekening">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.partials.footer')

    {{-- Toast notifikasi --}}
    <div class="toast" id="toast"></div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function openModal() {
            document.getElementById('modalRekening').classList.add('open');
        }

        function closeModal() {
            document.getElementById('modalRekening').classList.remove('open');
        }

        document.getElementById('modalRekening').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        async function saveRekening(e) {
            e.preventDefault();
            
            const btnSimpan = document.getElementById('btnSimpanRekening');
            const inputBank = document.getElementById('inputBank').value.trim();
            const inputRekening = document.getElementById('inputRekening').value.trim();
            const inputPemilik = document.getElementById('inputPemilik').value.trim();

            if(!inputBank || !inputRekening || !inputPemilik) return;

            btnSimpan.textContent = 'Menyimpan...';
            btnSimpan.disabled = true;

            const payload = {
                nama_bank: inputBank,
                nomor_rekening: inputRekening,
                nama_pemilik_rekening: inputPemilik
            };

            try {
                const response = await fetch("{{ route('store.pengaturan.updateRekening') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (result.success) {
                    // Update tampilan teks di halaman utama
                    document.getElementById('displayBank').textContent = inputBank;
                    document.getElementById('displayRekening').textContent = inputRekening;
                    document.getElementById('displayPemilik').textContent = inputPemilik;

                    closeModal();
                    showToast('Data rekening berhasil diperbarui!');
                } else {
                    showToast('Gagal memperbarui rekening. Periksa data Anda.');
                }
            } catch (error) {
                console.error(error);
                showToast('Terjadi kesalahan pada server.');
            } finally {
                btnSimpan.textContent = 'Simpan Perubahan';
                btnSimpan.disabled = false;
            }
        }

        /* ── Toast helper ── */
        function showToast(msg) {
            const t = document.getElementById('toast');
            t.textContent = '✓  ' + msg;
            t.classList.add('show');
            setTimeout(function() { t.classList.remove('show'); }, 2800);
        }
    </script>

</body>
</html>