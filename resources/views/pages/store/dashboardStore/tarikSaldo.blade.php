<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarik Saldo - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        body { background: #F5F7FA; font-family: 'Inter', sans-serif; }
        .page-wrap { width: 100%; max-width: 1289px; margin: 0 auto; padding: 28px 40px 60px; box-sizing: border-box; }

        .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .btn-back {
            width: 36px; height: 36px; border-radius: 50%;
            border: 1.5px solid #D1D5DB; background: #fff;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; color: #374151; flex-shrink: 0; transition: background .15s;
        }
        .btn-back:hover { background: #F3F4F6; }
        .page-title { font-size: 20px; font-weight: 700; color: #1E1E1E; margin: 0; }

        .card { background: #fff; border-radius: 14px; box-shadow: 0 2px 20px rgba(0,0,0,0.07); padding: 36px 40px; max-width: 680px; }

        /* Saldo info */
        .saldo-info {
            background: #EFF6FF;
            border-radius: 10px;
            padding: 18px 24px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .saldo-info-label { font-size: 13px; color: #34699A; font-weight: 500; }
        .saldo-info-amount { font-size: 22px; font-weight: 800; color: #34699A; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Info banner */
        .info-banner {
            background: #DBEAFE; border-radius: 8px;
            padding: 12px 16px; margin-bottom: 24px;
            font-size: 13px; color: #1E40AF; line-height: 1.5;
        }

        /* Form */
        .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
        .form-label { font-size: 14px; font-weight: 500; color: #374151; }
        .form-input {
            border: 1px solid #D1D5DB; border-radius: 8px;
            padding: 13px 16px; font-size: 14px; color: #374151;
            font-family: inherit; outline: none; background: #fff;
            transition: border-color .2s;
        }
        .form-input:focus { border-color: #34699A; box-shadow: 0 0 0 3px rgba(52,105,154,.1); }
        .form-input::placeholder { color: #9CA3AF; }
        .form-error { font-size: 12px; color: #EF4444; }

        /* Jumlah cepat */
        .quick-amounts { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
        .quick-btn {
            padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
            border: 1.5px solid #34699A; color: #34699A; background: #fff;
            cursor: pointer; transition: all .15s; font-family: inherit;
        }
        .quick-btn:hover { background: #34699A; color: #fff; }

        /* Rekening preview */
        .rekening-preview {
            background: #F9FAFB; border: 1px solid #E5E7EB;
            border-radius: 10px; padding: 16px 20px; margin-bottom: 24px;
        }
        .rekening-preview-title { font-size: 12px; font-weight: 600; color: #9CA3AF; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 12px; }
        .rekening-row { display: flex; justify-content: space-between; font-size: 13px; color: #374151; margin-bottom: 6px; }
        .rekening-row:last-child { margin-bottom: 0; }
        .rekening-row span:last-child { font-weight: 600; color: #1E1E1E; }

        .divider { border: none; border-top: 1px solid #E5E7EB; margin: 24px 0; }

        .btn-submit {
            background: #34699A; color: #fff; font-family: inherit;
            font-size: 15px; font-weight: 600; padding: 14px 48px;
            border-radius: 8px; border: none; cursor: pointer; transition: background .2s;
            width: 100%;
        }
        .btn-submit:hover { background: #2b5a87; }
        .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="page-wrap">

        <div class="page-header">
            <a href="{{ route('store.keuangan') }}" class="btn-back">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M10 13L5 8L10 3" stroke="#374151" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <h1 class="page-title">Tarik Saldo</h1>
        </div>

        <div class="card">

            {{-- Saldo tersedia --}}
            <div class="saldo-info">
                <span class="saldo-info-label">Saldo Tersedia</span>
                <span class="saldo-info-amount">Rp {{ number_format($saldo, 0, ',', '.') }}</span>
            </div>

            {{-- Info --}}
            <div class="info-banner">
                ℹ️ Penarikan saldo akan diproses dalam <strong>1–3 hari kerja</strong>. Pastikan rekening tujuan sudah benar sebelum melanjutkan.
            </div>

            @if ($errors->any())
                <div style="background:#FEF2F2;color:#B91C1C;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;">
                    <ul style="margin:0;padding-left:16px;">
                        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('store.tarikSaldo.proses') }}" method="POST" id="formTarik">
                @csrf

                {{-- Jumlah --}}
                <div class="form-group">
                    <label class="form-label">Jumlah Penarikan</label>
                    <input type="number" name="jumlah" id="input-jumlah" class="form-input"
                           placeholder="Contoh: 500000" min="10000" max="{{ $saldo }}"
                           value="{{ old('jumlah') }}" oninput="updatePreview()">
                    @error('jumlah') <span class="form-error">{{ $message }}</span> @enderror
                    <div class="quick-amounts">
                        <button type="button" class="quick-btn" onclick="setJumlah(100000)">Rp 100.000</button>
                        <button type="button" class="quick-btn" onclick="setJumlah(250000)">Rp 250.000</button>
                        <button type="button" class="quick-btn" onclick="setJumlah(500000)">Rp 500.000</button>
                        <button type="button" class="quick-btn" onclick="setJumlah(1000000)">Rp 1.000.000</button>
                        <button type="button" class="quick-btn" onclick="setJumlah({{ $saldo }})">Semua (Rp {{ number_format($saldo, 0, ',', '.') }})</button>
                    </div>
                </div>

                <hr class="divider">

                {{-- Info rekening dari toko --}}
                <div class="rekening-preview">
                    <div class="rekening-preview-title">Rekening Tujuan (dari data toko)</div>
                    <div class="rekening-row">
                        <span>Bank</span>
                        <span>{{ $toko->nama_bank }}</span>
                    </div>
                    <div class="rekening-row">
                        <span>Nomor Rekening</span>
                        <span>{{ $toko->nomor_rekening }}</span>
                    </div>
                    <div class="rekening-row">
                        <span>Nama Pemilik</span>
                        <span>{{ $toko->nama_pemilik_rekening }}</span>
                    </div>
                </div>

                {{-- Hidden fields dari data toko --}}
                <input type="hidden" name="nama_bank" value="{{ $toko->nama_bank }}">
                <input type="hidden" name="nomor_rekening" value="{{ $toko->nomor_rekening }}">
                <input type="hidden" name="nama_pemilik" value="{{ $toko->nama_pemilik_rekening }}">

                {{-- Tombol submit --}}
                <button type="button" onclick="bukaKonfirmasi()" class="btn-submit" id="btn-submit">
                    Tarik Saldo
                </button>

            </form>
        </div>

    </main>

    {{-- Modal Konfirmasi --}}
    <div id="modalKonfirmasi" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:999;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:14px;padding:32px 36px;max-width:440px;width:90%;box-shadow:0 8px 40px rgba(0,0,0,0.18);">
            <h3 style="font-size:16px;font-weight:700;color:#1E1E1E;margin:0 0 8px;">Konfirmasi Penarikan</h3>
            <p style="font-size:13px;color:#6B7280;margin:0 0 24px;">Pastikan semua data sudah benar sebelum melanjutkan.</p>

            <div style="background:#F9FAFB;border-radius:8px;padding:16px;margin-bottom:20px;">
                <div style="display:flex;justify-content:space-between;font-size:13px;color:#374151;margin-bottom:8px;">
                    <span>Jumlah Penarikan</span>
                    <span style="font-weight:700;color:#34699A;font-size:16px;" id="modal-jumlah">-</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px;color:#374151;margin-bottom:8px;">
                    <span>Tujuan Bank</span>
                    <span style="font-weight:600;">{{ $toko->nama_bank }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px;color:#374151;margin-bottom:8px;">
                    <span>Nomor Rekening</span>
                    <span style="font-weight:600;">{{ $toko->nomor_rekening }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px;color:#374151;">
                    <span>Atas Nama</span>
                    <span style="font-weight:600;">{{ $toko->nama_pemilik_rekening }}</span>
                </div>
            </div>

            <div style="display:flex;gap:12px;">
                <button onclick="tutupKonfirmasi()"
                    style="flex:1;padding:12px;border-radius:8px;border:1.5px solid #D1D5DB;background:#fff;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;">
                    Batal
                </button>
                <button onclick="document.getElementById('formTarik').submit()"
                    style="flex:1;padding:12px;border-radius:8px;border:none;background:#34699A;color:#fff;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;">
                    Ya, Tarik Sekarang
                </button>
            </div>
        </div>
    </div>

    @include('layouts.partials.footer')

    <script>
        function setJumlah(val) {
            document.getElementById('input-jumlah').value = val;
            updatePreview();
        }
        function updatePreview() {
            const val = parseInt(document.getElementById('input-jumlah').value) || 0;
            document.getElementById('modal-jumlah').textContent = 'Rp ' + val.toLocaleString('id-ID');
        }
        function bukaKonfirmasi() {
            const val = parseInt(document.getElementById('input-jumlah').value) || 0;
            if (val < 10000) { alert('Minimum penarikan Rp 10.000'); return; }
            updatePreview();
            const m = document.getElementById('modalKonfirmasi');
            m.style.display = 'flex';
        }
        function tutupKonfirmasi() {
            document.getElementById('modalKonfirmasi').style.display = 'none';
        }
        document.getElementById('modalKonfirmasi').addEventListener('click', function(e) {
            if (e.target === this) tutupKonfirmasi();
        });
    </script>

</body>
</html>