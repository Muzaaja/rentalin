<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Toko - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * { font-family: 'Inter', sans-serif; }
        .toko-wrap { width:100%; max-width:1289px; margin:0 auto; padding:28px 40px 60px; box-sizing:border-box; }

        .toko-header { display:flex; align-items:center; gap:14px; margin-bottom:28px; }
        .btn-back-circle { width:34px; height:34px; background:transparent; border:none; padding:0; display:flex; align-items:center; justify-content:center; text-decoration:none; transition:opacity .15s; flex-shrink:0; cursor:pointer; }
        .btn-back-circle:hover { opacity:0.7; }
        .btn-back-circle img { display:block; width:28px; height:28px; object-fit:contain; }
        .toko-header h1 { font-size:20px; font-weight:700; color:#1E1E1E; margin:0; }

        /* Stepper */
        .stepper { display:flex; align-items:center; margin-bottom:28px; }
        .step-node { display:flex; flex-direction:column; align-items:center; flex-shrink:0; }
        .step-circle { width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:16px; }
        .step-circle.active   { background:#34699A; color:#fff; }
        .step-circle.inactive { background:#E5E7EB; border:1px solid #D1D5DB; color:#9CA3AF; }
        .step-text { font-size:12px; margin-top:6px; white-space:nowrap; color:#9CA3AF; }
        .step-text.active { font-weight:600; color:#34699A; }
        .step-connector { flex:1; height:2px; background:#D1D5DB; align-self:flex-start; margin-top:22px; }
        .step-connector.done { background:#34699A; }

        /* Privacy banner */
        .privacy-banner { display:flex; align-items:flex-start; gap:12px; background:#DBEAFE; border-radius:10px; padding:14px 18px; margin-bottom:24px; }
        .privacy-banner p { font-size:13px; color:#1E40AF; line-height:1.6; margin:0; }

        /* Form card */
        .form-card { background:#fff; border-radius:14px; box-shadow:0 2px 20px rgba(0,0,0,0.07); padding:40px 48px; }
        .section-title { font-size:16px; font-weight:700; color:#1E1E1E; margin:0 0 20px; }
        .alert-error { background:#FEF2F2; color:#B91C1C; padding:12px 16px; border-radius:8px; margin-bottom:24px; font-size:13px; }
        .alert-error ul { margin:0; padding-left:16px; }

        /* Grid */
        .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:28px; margin-bottom:24px; }
        .grid-2.same-height { align-items:stretch; }
        .fg { display:flex; flex-direction:column; gap:8px; }
        .fg > label { font-size:14px; font-weight:500; color:#374151; }

        /* Input */
        .fi { width:100%; box-sizing:border-box; border:1.5px solid #D1D5DB; border-radius:8px; padding:13px 16px; font-size:14px; color:#374151; font-family:inherit; outline:none; background:#fff; transition:border-color .2s, box-shadow .2s; }
        .fi::placeholder { color:#9CA3AF; }
        .fi:focus { border-color:#34699A; box-shadow:0 0 0 3px rgba(52,105,154,.1); }
        .fi.is-valid   { border-color:#16A34A !important; }
        .fi.is-invalid { border-color:#EF4444 !important; }

        /* Feedback */
        .field-err { font-size:12px; color:#EF4444; display:none; align-items:center; gap:4px; }
        .field-ok  { font-size:12px; color:#16A34A; display:none; align-items:center; gap:4px; }
        .field-err i, .field-ok i { font-size:13px; }

        /* Upload KTP */
        .upload-area { border:2px dashed #93C5FD; border-radius:10px; background:#F0F7FF; cursor:pointer; position:relative; height:100%; min-height:180px; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:24px 16px; text-align:center; box-sizing:border-box; transition:border-color .2s, background .2s; }
        .upload-area.is-uploaded { border-color:#16A34A; background:#F0FDF4; }
        .upload-area.is-error    { border-color:#EF4444; background:#FEF2F2; }
        .upload-area input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
        .upload-icon { font-size:32px; color:#93C5FD; margin-bottom:8px; line-height:1; }
        .upload-area.is-uploaded .upload-icon { color:#16A34A; }
        .upload-title { font-weight:600; font-size:14px; color:#374151; }
        .upload-hint  { font-size:12px; color:#9CA3AF; margin-top:4px; }

        /* Selfie box */
        .selfie-box { border:2px dashed #D1D5DB; border-radius:10px; background:#F9FAFB; height:100%; min-height:180px; padding:20px 20px 24px; display:flex; flex-direction:column; justify-content:space-between; box-sizing:border-box; transition:border-color .2s, background .2s; }
        .selfie-box.is-uploaded { border-color:#16A34A; background:#F0FDF4; }
        .selfie-box.is-error    { border-color:#EF4444; }
        .selfie-checks { list-style:none !important; padding:0 !important; margin:0 0 16px !important; }
        .selfie-checks li { font-size:13px; color:#16A34A; margin-bottom:6px; padding-left:0 !important; display:flex; align-items:flex-start; gap:6px; }
        .selfie-checks li::before { content:"✓"; font-weight:700; color:#16A34A; flex-shrink:0; }
        .btn-foto { display:inline-flex; align-items:center; gap:8px; background:#34699A; color:#fff; border:none; padding:10px 24px; border-radius:7px; font-weight:600; font-size:14px; font-family:inherit; cursor:pointer; }
        .btn-foto i { font-size:15px; line-height:1; }

        /* Divider */
        .divider { border:none; border-top:1px solid #E5E7EB; margin:28px 0; }

        /* Submit */
        .form-footer { text-align:center; margin-top:40px; }
        .btn-lanjut { background:#34699A; color:#fff; font-family:inherit; font-weight:600; font-size:15px; padding:14px 64px; border-radius:8px; border:none; cursor:pointer; transition:background .2s; }
        .btn-lanjut:hover { background:#2b5a87; }

        /* Modal */
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:999; align-items:center; justify-content:center; }
        .modal-overlay.show { display:flex; }
        .modal-box { background:#fff; border-radius:14px; padding:32px 36px; max-width:520px; width:90%; box-shadow:0 8px 40px rgba(0,0,0,0.18); }
        .modal-top { display:flex; align-items:center; gap:12px; margin-bottom:16px; }
        .modal-icon { background:#E0E7FF; padding:10px; border-radius:8px; display:flex; align-items:center; justify-content:center; }
        .modal-ttl { font-weight:700; font-size:15px; color:#1E1E1E; margin:0; }
        .modal-sub { font-size:12px; color:#6B7280; margin:3px 0 0; }
        .modal-section { font-size:11px; font-weight:700; color:#9CA3AF; letter-spacing:.08em; text-transform:uppercase; margin:16px 0 8px; }
        .modal-table { border:1px solid #E5E7EB; border-radius:8px; padding:0 16px; }
        .modal-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #F3F4F6; font-size:13px; color:#374151; }
        .modal-row:last-child { border-bottom:none; }
        .badge-ok  { background:#DCFCE7; color:#16A34A; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
        .badge-err { background:#FEF2F2; color:#B91C1C; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
        .modal-actions { display:flex; gap:12px; margin-top:24px; justify-content:center; }
        .btn-cek   { background:#fff; border:1.5px solid #34699A; color:#34699A; padding:12px 28px; border-radius:8px; font-weight:600; cursor:pointer; font-size:14px; font-family:inherit; display:inline-flex; align-items:center; gap:8px; }
        .btn-kirim { background:#34699A; color:#fff; border:none; padding:12px 28px; border-radius:8px; font-weight:600; cursor:pointer; font-size:14px; font-family:inherit; display:inline-flex; align-items:center; gap:8px; }
        .btn-kirim:hover:not(:disabled) { background:#2b5a87; }
        .btn-kirim:disabled { background:#9CA3AF; cursor:not-allowed; }
        .btn-cek i, .btn-kirim i { font-size:16px; line-height:1; }

        /* Modal error banner */
        .modal-error-banner { background:#FEF2F2; border:1px solid #FECACA; border-radius:8px; padding:12px 14px; margin-bottom:16px; font-size:13px; color:#B91C1C; display:none; }
        .modal-error-banner.show { display:block; }
        .modal-error-banner ul { margin:4px 0 0; padding-left:16px; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    {{-- Modal Konfirmasi --}}
    <div class="modal-overlay" id="modalKonfirmasi">
        <div class="modal-box">
            <div class="modal-top">
                <div class="modal-icon">
                    <i class="bi bi-file-earmark-text-fill" style="font-size:24px;color:#34699A;"></i>
                </div>
                <div>
                    <p class="modal-ttl">Konfirmasi data verifikasi</p>
                    <p class="modal-sub">Pastikan semua data sudah benar sebelum dikirim</p>
                </div>
            </div>

            <div class="modal-error-banner" id="modalErrorBanner">
                <strong>Data belum lengkap atau tidak valid:</strong>
                <ul id="modalErrorList"></ul>
            </div>

            <div class="modal-section">Identitas Diri</div>
            <div class="modal-table">
                <div class="modal-row"><span>Nama lengkap</span><span id="preview-nama" style="color:#111;font-weight:500;">—</span></div>
                <div class="modal-row"><span>NIK</span><span id="preview-nik" style="color:#111;font-weight:500;">—</span></div>
                <div class="modal-row"><span>Foto KTP</span><span class="badge-err" id="preview-ktp">Belum diunggah</span></div>
                <div class="modal-row"><span>Selfie dengan KTP</span><span class="badge-err" id="preview-selfie">Belum diunggah</span></div>
            </div>

            <div class="modal-section">Rekening Pencairan</div>
            <div class="modal-table">
                <div class="modal-row"><span>Bank</span><span id="preview-bank" style="color:#111;font-weight:500;">—</span></div>
                <div class="modal-row"><span>Nomor rekening</span><span id="preview-rekening" style="color:#111;font-weight:500;">—</span></div>
                <div class="modal-row"><span>Nama pemilik</span><span id="preview-pemilik" style="color:#111;font-weight:500;">—</span></div>
            </div>

            <div class="modal-actions">
                <button class="btn-cek" onclick="tutupModal()">
                    <i class="bi bi-pencil-square"></i> Cek lagi
                </button>
                <button class="btn-kirim" id="btnKirim" onclick="submitForm()">
                    <i class="bi bi-send-fill"></i> Ya, kirim sekarang
                </button>
            </div>
        </div>
    </div>

    <main class="toko-wrap">

        <div class="toko-header">
            <a href="{{ url()->previous() }}" class="btn-back-circle" title="Kembali">
                <img src="{{ asset('assets/icons/icon-back.png') }}" alt="Kembali">
            </a>
            <h1>Verifikasi Toko</h1>
        </div>

        <div class="stepper">
            <div class="step-node">
                <div class="step-circle inactive">1</div>
                <span class="step-text">Data Toko</span>
            </div>
            <div class="step-connector done"></div>
            <div class="step-node">
                <div class="step-circle active">2</div>
                <span class="step-text active">Verifikasi</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-node">
                <div class="step-circle inactive">3</div>
                <span class="step-text">Selesai</span>
            </div>
        </div>

        <div class="privacy-banner">
            <i class="bi bi-info-circle-fill" style="font-size:18px;color:#2563EB;flex-shrink:0;margin-top:1px;"></i>
            <p><strong>Pesan Privasi</strong><br>
            Data sensitif anda terenkripsi dan hanya digunakan untuk kebutuhan verifikasi. Rentalin tidak akan membagikan Kartu Identitas anda kepada pengguna lain.</p>
        </div>

        <div class="form-card">

            @if ($errors->any())
                <div class="alert-error">
                    <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form id="formStep2" action="{{ route('store.step2Toko.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h2 class="section-title">Data Diri</h2>

                <div class="grid-2">
                    {{-- NIK: hanya angka, 16 digit --}}
                    <div class="fg">
                        <label>NIK (nomor KTP)</label>
                        <input type="text" name="nik" id="input-nik" class="fi"
                               placeholder="16 digit nomor KTP" maxlength="16"
                               inputmode="numeric" autocomplete="off"
                               value="{{ old('nik') }}">
                        <span class="field-err" id="err-nik"><i class="bi bi-x-circle-fill"></i> <span class="msg"></span></span>
                        <span class="field-ok"  id="ok-nik"><i class="bi bi-check-circle-fill"></i> NIK valid</span>
                    </div>
                    {{-- Nama KTP: hanya huruf dan spasi --}}
                    <div class="fg">
                        <label>Nama lengkap sesuai KTP</label>
                        <input type="text" name="nama_lengkap_ktp" id="input-nama" class="fi"
                               placeholder="Masukkan nama sesuai KTP"
                               autocomplete="off"
                               value="{{ old('nama_lengkap_ktp') }}">
                        <span class="field-err" id="err-nama"><i class="bi bi-x-circle-fill"></i> <span class="msg"></span></span>
                        <span class="field-ok"  id="ok-nama"><i class="bi bi-check-circle-fill"></i> Nama valid</span>
                    </div>
                </div>

                <div class="grid-2 same-height" style="margin-bottom:32px;">
                    {{-- Upload KTP --}}
                    <div class="fg">
                        <label>Kartu Identitas</label>
                        <label class="upload-area" id="area-ktp">
                            <input type="file" name="foto_ktp" id="input-ktp" accept="image/*">
                            <div id="ktp-inner">
                                <div class="upload-icon"><i class="bi bi-cloud-arrow-up-fill" id="icon-ktp"></i></div>
                                <div class="upload-title" id="text-ktp">Unggah Foto Identitas Diri</div>
                                <div class="upload-hint">Klik untuk memilih file</div>
                            </div>
                        </label>
                        <span class="field-err" id="err-ktp"><i class="bi bi-x-circle-fill"></i> Foto KTP wajib diunggah</span>
                    </div>

                    {{-- Selfie --}}
                    <div class="fg">
                        <label>Verifikasi Selfie</label>
                        <div class="selfie-box" id="area-selfie">
                            <ul class="selfie-checks">
                                <li>Pencahayaan bagus, tidak ada bayangan wajah</li>
                                <li>Wajah harus terlihat jelas, tidak memakai topi/kacamata</li>
                                <li>Wajah harus sesuai dengan kartu identitas</li>
                            </ul>
                            <div>
                                <label id="label-btn-selfie" style="cursor:pointer;">
                                    <div class="btn-foto" id="btn-selfie-text">
                                        <i class="bi bi-camera-fill"></i> Foto
                                    </div>
                                    <input type="file" name="foto_selfie" id="input-selfie" accept="image/*" style="display:none;">
                                </label>
                                <div id="label-selfie" style="font-size:12px;color:#16A34A;margin-top:8px;"></div>
                            </div>
                        </div>
                        <span class="field-err" id="err-selfie"><i class="bi bi-x-circle-fill"></i> Foto selfie wajib diunggah</span>
                    </div>
                </div>

                <hr class="divider">

                <h2 class="section-title">Rekening Pencairan</h2>

                <div class="grid-2">
                    {{-- Nama Bank: hanya huruf --}}
                    <div class="fg">
                        <label>Nama Bank</label>
                        <input type="text" name="nama_bank" id="input-bank" class="fi"
                               placeholder="Contoh: BCA, Mandiri, BRI"
                               autocomplete="off"
                               value="{{ old('nama_bank') }}">
                        <span class="field-err" id="err-bank"><i class="bi bi-x-circle-fill"></i> <span class="msg"></span></span>
                        <span class="field-ok"  id="ok-bank"><i class="bi bi-check-circle-fill"></i> Nama bank valid</span>
                    </div>
                    {{-- Nomor Rekening: hanya angka --}}
                    <div class="fg">
                        <label>Nomor Rekening</label>
                        <input type="text" name="nomor_rekening" id="input-rekening" class="fi"
                               placeholder="Masukkan nomor rekening"
                               inputmode="numeric" autocomplete="off"
                               value="{{ old('nomor_rekening') }}">
                        <span class="field-err" id="err-rekening"><i class="bi bi-x-circle-fill"></i> <span class="msg"></span></span>
                        <span class="field-ok"  id="ok-rekening"><i class="bi bi-check-circle-fill"></i> Nomor rekening valid</span>
                    </div>
                </div>

                {{-- Nama pemilik rekening: harus sama dengan nama KTP --}}
                <div class="fg" style="margin-bottom:0;">
                    <label>Nama Pemilik Rekening</label>
                    <input type="text" name="nama_pemilik_rekening" id="input-pemilik" class="fi"
                           placeholder="Harus sama dengan nama di KTP"
                           autocomplete="off"
                           value="{{ old('nama_pemilik_rekening') }}">
                    <span class="field-err" id="err-pemilik"><i class="bi bi-x-circle-fill"></i> <span class="msg"></span></span>
                    <span class="field-ok"  id="ok-pemilik"><i class="bi bi-check-circle-fill"></i> Nama cocok dengan KTP</span>
                </div>

                <div class="form-footer">
                    <button type="button" onclick="bukaModal()" class="btn-lanjut">Lanjutkan</button>
                </div>

            </form>
        </div>

    </main>

    @include('layouts.partials.footer')

    <script>
    (function () {
        // ── State ──────────────────────────────────────────
        const state = { ktp: false, selfie: false };

        // ── Aturan validasi per field ──────────────────────
        // validate(v) → string pesan error, atau null jika valid
        const rules = {
            'input-nik': {
                filter : /[^0-9]/g,
                validate(v) {
                    if (!v)              return 'NIK wajib diisi';
                    if (v.length !== 16) return `NIK harus 16 digit (sekarang ${v.length})`;
                    return null;
                },
                errId: 'err-nik', okId: 'ok-nik'
            },
            'input-nama': {
                filter : /[^a-zA-Z\s]/g,
                validate(v) {
                    if (!v)             return 'Nama lengkap wajib diisi';
                    if (v.length < 3)   return 'Nama minimal 3 karakter';
                    return null;
                },
                errId: 'err-nama', okId: 'ok-nama'
            },
            'input-bank': {
                filter : /[^a-zA-Z\s]/g,
                validate(v) {
                    if (!v) return 'Nama bank wajib diisi';
                    return null;
                },
                errId: 'err-bank', okId: 'ok-bank'
            },
            'input-rekening': {
                filter : /[^0-9]/g,
                validate(v) {
                    if (!v)          return 'Nomor rekening wajib diisi';
                    if (v.length < 6) return 'Nomor rekening terlalu pendek (min 6 digit)';
                    return null;
                },
                errId: 'err-rekening', okId: 'ok-rekening'
            },
            'input-pemilik': {
                filter : /[^a-zA-Z\s]/g,
                validate(v) {
                    if (!v)           return 'Nama pemilik rekening wajib diisi';
                    if (v.length < 3) return 'Nama minimal 3 karakter';
                    // Cross-check: harus sama dengan nama KTP (case-insensitive)
                    const namaKtp = document.getElementById('input-nama').value.trim().toLowerCase();
                    if (namaKtp && v.trim().toLowerCase() !== namaKtp) {
                        return 'Nama pemilik rekening harus sama dengan nama di KTP';
                    }
                    return null;
                },
                errId: 'err-pemilik', okId: 'ok-pemilik'
            },
        };

        // ── Helper: tampilkan / sembunyikan feedback ───────
        function setFieldState(id, errorMsg) {
            const rule  = rules[id];
            const input = document.getElementById(id);
            const errEl = document.getElementById(rule.errId);
            const okEl  = document.getElementById(rule.okId);

            if (errorMsg) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                errEl.querySelector('.msg').textContent = errorMsg;
                errEl.style.display = 'flex';
                if (okEl) okEl.style.display = 'none';
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                errEl.style.display = 'none';
                if (okEl) okEl.style.display = 'flex';
            }
        }

        function validateField(id) {
            const rule = rules[id];
            const val  = document.getElementById(id).value.trim();
            setFieldState(id, rule.validate(val));
        }

        // ── Pasang event ke setiap field ───────────────────
        Object.entries(rules).forEach(([id, rule]) => {
            const input = document.getElementById(id);
            if (!input) return;

            // Filter karakter tidak valid saat mengetik
            input.addEventListener('input', function () {
                if (rule.filter) {
                    const pos      = this.selectionStart;
                    const filtered = this.value.replace(rule.filter, '');
                    if (filtered !== this.value) {
                        this.value = filtered;
                        try { this.setSelectionRange(pos - 1, pos - 1); } catch(e) {}
                    }
                }
                validateField(id);

                // Jika nama KTP berubah, re-validasi pemilik juga
                if (id === 'input-nama') validateField('input-pemilik');
            });

            input.addEventListener('blur', () => validateField(id));
        });

        // ── Upload KTP ─────────────────────────────────────
        document.getElementById('input-ktp').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            state.ktp = true;

            const area = document.getElementById('area-ktp');
            area.classList.add('is-uploaded');
            area.classList.remove('is-error');
            document.getElementById('icon-ktp').className = 'bi bi-check-circle-fill';
            document.getElementById('text-ktp').textContent = '✓ ' + file.name;
            document.getElementById('err-ktp').style.display = 'none';

            // Update badge modal
            const badge = document.getElementById('preview-ktp');
            badge.textContent = 'Diunggah ✓';
            badge.className   = 'badge-ok';
        });

        // ── Upload Selfie ──────────────────────────────────
        document.getElementById('input-selfie').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            state.selfie = true;

            const area = document.getElementById('area-selfie');
            area.classList.add('is-uploaded');
            area.classList.remove('is-error');
            document.getElementById('btn-selfie-text').innerHTML = '<i class="bi bi-camera-fill"></i> Foto Ulang';
            document.getElementById('label-selfie').textContent  = '✓ ' + file.name;
            document.getElementById('err-selfie').style.display  = 'none';

            // Update badge modal
            const badge = document.getElementById('preview-selfie');
            badge.textContent = 'Diunggah ✓';
            badge.className   = 'badge-ok';
        });

        // ── Sync preview di modal ──────────────────────────
        function syncPreview() {
            document.getElementById('preview-nama').textContent     = document.getElementById('input-nama').value.trim()     || '—';
            document.getElementById('preview-nik').textContent      = document.getElementById('input-nik').value.trim()      || '—';
            document.getElementById('preview-bank').textContent     = document.getElementById('input-bank').value.trim()     || '—';
            document.getElementById('preview-rekening').textContent = document.getElementById('input-rekening').value.trim() || '—';
            document.getElementById('preview-pemilik').textContent  = document.getElementById('input-pemilik').value.trim()  || '—';
        }

        // ── Buka modal ─────────────────────────────────────
        window.bukaModal = function () {
            // Validasi semua field teks
            Object.keys(rules).forEach(id => validateField(id));

            // Validasi upload
            if (!state.ktp) {
                document.getElementById('err-ktp').style.display = 'flex';
                document.getElementById('area-ktp').classList.add('is-error');
            }
            if (!state.selfie) {
                document.getElementById('err-selfie').style.display = 'flex';
                document.getElementById('area-selfie').classList.add('is-error');
            }

            // Kumpulkan semua error
            const errors = [];
            Object.entries(rules).forEach(([id, rule]) => {
                const msg = rule.validate(document.getElementById(id).value.trim());
                if (msg) errors.push(msg);
            });
            if (!state.ktp)    errors.push('Foto KTP belum diunggah');
            if (!state.selfie) errors.push('Foto selfie belum diunggah');

            // Tampilkan/sembunyikan banner error & tombol kirim
            const banner   = document.getElementById('modalErrorBanner');
            const list     = document.getElementById('modalErrorList');
            const btnKirim = document.getElementById('btnKirim');

            syncPreview();

            if (errors.length > 0) {
                list.innerHTML      = errors.map(e => `<li>${e}</li>`).join('');
                banner.classList.add('show');
                btnKirim.disabled   = true;
            } else {
                banner.classList.remove('show');
                btnKirim.disabled   = false;
            }

            document.getElementById('modalKonfirmasi').classList.add('show');
        };

        window.tutupModal = function () {
            document.getElementById('modalKonfirmasi').classList.remove('show');
        };

        window.submitForm = function () {
            document.getElementById('formStep2').submit();
        };

        // Klik di luar modal → tutup
        document.getElementById('modalKonfirmasi').addEventListener('click', function (e) {
            if (e.target === this) tutupModal();
        });

    })();
    </script>

</body>
</html>