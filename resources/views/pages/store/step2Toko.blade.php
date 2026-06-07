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
        .toko-wrap { width:100%; max-width:1289px; margin:0 auto; padding:28px 40px 60px; box-sizing:border-box; }

        /* Header */
        .toko-header { display:flex; align-items:center; gap:14px; margin-bottom:28px; }
        
        /* REVISI: Ukuran tombol back disesuaikan dengan w-[34px] h-[34px] */
        .btn-back-circle {
            width: 34px;
            height: 34px;
            background: transparent; 
            border: none;            
            padding: 0;              
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; 
            transition: opacity .15s; 
            flex-shrink: 0;
            cursor: pointer;
        }
        
        .btn-back-circle:hover { 
            background: transparent; 
            opacity: 0.7;             
        }
        
        /* REVISI: Ukuran gambar disesuaikan dengan w-[28px] h-[28px] object-contain */
        .btn-back-circle img { 
            display: block; 
            width: 28px; 
            height: 28px; 
            object-fit: contain; 
        }
        
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
        .privacy-banner {
            display:flex; align-items:flex-start; gap:12px;
            background:#DBEAFE; border-radius:10px;
            padding:14px 18px; margin-bottom:24px;
        }
        .privacy-banner p { font-size:13px; color:#1E40AF; line-height:1.6; margin:0; }

        /* Form card */
        .form-card { background:#fff; border-radius:14px; box-shadow:0 2px 20px rgba(0,0,0,0.07); padding:40px 48px; }
        .section-title { font-size:16px; font-weight:700; color:#1E1E1E; margin:0 0 20px; }

        /* Error */
        .alert-error { background:#FEF2F2; color:#B91C1C; padding:12px 16px; border-radius:8px; margin-bottom:24px; font-size:13px; }
        .alert-error ul { margin:0; padding-left:16px; }

        /* Grid & groups */
        .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:28px; margin-bottom:24px; }
        .grid-2.same-height { align-items:stretch; }
        .fg { display:flex; flex-direction:column; gap:8px; }
        .fg label { font-size:14px; font-weight:500; color:#374151; }
        .fi {
            width:100%; box-sizing:border-box;
            border:1px solid #D1D5DB; border-radius:8px;
            padding:13px 16px; font-size:14px; color:#374151;
            font-family:inherit; outline:none; background:#fff;
            transition:border-color .2s, box-shadow .2s;
        }
        .fi::placeholder { color:#9CA3AF; }
        .fi:focus { border-color:#34699A; box-shadow:0 0 0 3px rgba(52,105,154,.1); }
        .fe { font-size:12px; color:#EF4444; }

        /* Upload KTP */
        .upload-area {
            border:2px dashed #93C5FD; border-radius:10px;
            background:#F0F7FF; cursor:pointer; position:relative;
            height:100%; min-height:180px;
            display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            padding:24px 16px; text-align:center;
            box-sizing:border-box;
        }
        .upload-area input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
        .upload-icon { font-size:32px; color:#93C5FD; margin-bottom:8px; line-height:1; }
        .upload-title { font-weight:600; font-size:14px; color:#374151; }
        .upload-hint  { font-size:12px; color:#9CA3AF; margin-top:4px; }

        /* Selfie box */
        .selfie-box {
            border:2px dashed #D1D5DB; border-radius:10px;
            background:#F9FAFB;
            height:100%; min-height:180px;
            padding:20px 20px 24px;
            display:flex; flex-direction:column; justify-content:space-between;
            box-sizing:border-box;
        }

        /* Selfie checklist */
        .selfie-checks {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 0 16px !important;
        }
        .selfie-checks li {
            font-size: 13px;
            color: #16A34A;
            margin-bottom: 6px;
            padding-left: 0 !important;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }
        .selfie-checks li::before {
            content: "✓";
            font-weight: 700;
            color: #16A34A;
            flex-shrink: 0;
        }
        .selfie-checks li::marker { display: none; }

        /* Tombol foto */
        .btn-foto {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #34699A;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 7px;
            font-weight: 600;
            font-size: 14px;
            font-family: inherit;
            cursor: pointer;
        }
        .btn-foto i { font-size: 15px; line-height: 1; }

        /* Divider */
        .divider { border:none; border-top:1px solid #E5E7EB; margin:28px 0; }

        /* Submit */
        .form-footer { text-align:center; margin-top:40px; }
        .btn-lanjut {
            background:#34699A; color:#fff;
            font-family:inherit; font-weight:600; font-size:15px;
            padding:14px 64px; border-radius:8px; border:none;
            cursor:pointer; transition:background .2s;
        }
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
        .badge-ok { background:#DCFCE7; color:#16A34A; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
        .modal-actions { display:flex; gap:12px; margin-top:24px; justify-content:center; }
        
        .btn-cek { 
            background:#fff; border:1.5px solid #34699A; color:#34699A; padding:12px 28px; border-radius:8px; font-weight:600; cursor:pointer; font-size:14px; font-family:inherit;
            display:inline-flex; align-items:center; gap:8px; 
        }
        .btn-kirim { 
            background:#34699A; color:#fff; border:none; padding:12px 28px; border-radius:8px; font-weight:600; cursor:pointer; font-size:14px; font-family:inherit; 
            display:inline-flex; align-items:center; gap:8px; 
        }
        .btn-kirim:hover { background:#2b5a87; }
        
        .btn-cek i, .btn-kirim i { font-size: 16px; display: inline-block; line-height: 1; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    {{-- Modal Konfirmasi --}}
    <div class="modal-overlay" id="modalKonfirmasi">
        <div class="modal-box">
            <div class="modal-top">
                <div class="modal-icon">
                    <i class="bi bi-file-earmark-text-fill" style="font-size: 24px; color: #34699A;"></i>
                </div>
                <div>
                    <p class="modal-ttl">Konfirmasi data verifikasi</p>
                    <p class="modal-sub">Pastikan semua data sudah benar sebelum dikirim</p>
                </div>
            </div>

            <div class="modal-section">Identitas Diri</div>
            <div class="modal-table">
                <div class="modal-row"><span>Nama lengkap</span><span id="preview-nama" style="color:#111;font-weight:500;">—</span></div>
                <div class="modal-row"><span>NIK</span><span id="preview-nik" style="color:#111;font-weight:500;">—</span></div>
                <div class="modal-row"><span>Foto KTP</span><span class="badge-ok" id="preview-ktp">Diunggah ✓</span></div>
                <div class="modal-row"><span>Selfie dengan KTP</span><span class="badge-ok" id="preview-selfie">Diunggah ✓</span></div>
            </div>

            <div class="modal-section">Rekening Pencairan</div>
            <div class="modal-table">
                <div class="modal-row"><span>Bank</span><span id="preview-bank" style="color:#111;font-weight:500;">—</span></div>
                <div class="modal-row"><span>Nomor rekening</span><span id="preview-rekening" style="color:#111;font-weight:500;">—</span></div>
                <div class="modal-row"><span>Nama pemilik</span><span id="preview-pemilik" style="color:#111;font-weight:500;">—</span></div>
            </div>

            <div class="modal-actions">
                <button class="btn-cek" onclick="tutupModal()">
                    <i class="bi bi-pencil-square"></i>
                    Cek lagi
                </button>
                <button class="btn-kirim" onclick="document.getElementById('formStep2').submit()">
                    <i class="bi bi-send-fill"></i>
                    Ya, kirim sekarang
                </button>
            </div>
        </div>
    </div>

    <main class="toko-wrap">

        {{-- Header --}}
        <div class="toko-header">
            {{-- SELESAI DISESUAIKAN: Menggunakan url()->previous() dan ukuran persis seperti code temanmu --}}
            <a href="{{ url()->previous() }}" class="btn-back-circle" title="Kembali">
                <img src="{{ asset('assets/icons/icon-back.png') }}" alt="Kembali">
            </a>
            <h1>Verifikasi Toko</h1>
        </div>

        {{-- Stepper --}}
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

        {{-- Privacy Banner --}}
        <div class="privacy-banner">
            <i class="bi bi-info-circle-fill" style="font-size:18px;color:#2563EB;flex-shrink:0;margin-top:1px;"></i>
            <p><strong>Pesan Privasi</strong><br>
            Data sensitif anda terenkripsi dan hanya digunakan untuk kebutuhan verifikasi. Rentalin tidak akan membagikan Kartu Identitas anda kepada pengguna lain.</p>
        </div>

        {{-- Form Card --}}
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
                    <div class="fg">
                        <label>NIK (nomor KTP)</label>
                        <input type="text" name="nik" id="input-nik" class="fi"
                               placeholder="16 digit nomor KTP" maxlength="16"
                               value="{{ old('nik') }}" oninput="syncPreview()">
                        @error('nik')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                    <div class="fg">
                        <label>Nama lengkap sesuai KTP</label>
                        <input type="text" name="nama_lengkap_ktp" id="input-nama" class="fi"
                               placeholder="Masukkan nama sesuai KTP"
                               value="{{ old('nama_lengkap_ktp') }}" oninput="syncPreview()">
                        @error('nama_lengkap_ktp')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="grid-2 same-height" style="margin-bottom:32px;">
                    {{-- Upload KTP --}}
                    <div class="fg">
                        <label>Kartu Identitas</label>
                        <label class="upload-area">
                            <input type="file" name="foto_ktp" accept="image/*"
                                   onchange="handleUpload(this,'preview-ktp','label-ktp')">
                            <div id="label-ktp">
                                <div class="upload-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                                <div class="upload-title">Unggah Foto Identitas Diri</div>
                                <div class="upload-hint">Klik untuk menggantikan dokumen</div>
                            </div>
                        </label>
                        @error('foto_ktp')<span class="fe">{{ $message }}</span>@enderror
                    </div>

                    {{-- Selfie --}}
                    <div class="fg">
                        <label>Verifikasi Selfie</label>
                        <div class="selfie-box">
                            <ul class="selfie-checks">
                                <li>Pencahayaan bagus, tidak ada bayangan wajah</li>
                                <li>Wajah harus terlihat jelas, tidak memakai topi/kacamata</li>
                                <li>Wajah harus sesuai dengan kartu identitas</li>
                            </ul>
                            <div>
                                <label id="label-btn-selfie" style="cursor:pointer;">
                                    <div class="btn-foto"><i class="bi bi-camera-fill"></i> Foto</div>
                                    <input type="file" name="foto_selfie" accept="image/*"
                                           style="display:none;" onchange="handleSelfie(this)">
                                </label>
                                <div id="label-selfie" style="font-size:12px;color:#16A34A;margin-top:8px;"></div>
                            </div>
                        </div>
                        @error('foto_selfie')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                </div>

                <hr class="divider">

                <h2 class="section-title">Rekening Pencairan</h2>

                <div class="grid-2">
                    <div class="fg">
                        <label>Nama Bank</label>
                        <input type="text" name="nama_bank" id="input-bank" class="fi"
                               placeholder="Masukkan nama Bank"
                               value="{{ old('nama_bank') }}" oninput="syncPreview()">
                        @error('nama_bank')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                    <div class="fg">
                        <label>Nomor Rekening</label>
                        <input type="text" name="nomor_rekening" id="input-rekening" class="fi"
                               placeholder="Masukkan nomor rekening"
                               value="{{ old('nomor_rekening') }}" oninput="syncPreview()">
                        @error('nomor_rekening')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="fg" style="margin-bottom:0;">
                    <label>Nama Pemilik Rekening</label>
                    <input type="text" name="nama_pemilik_rekening" id="input-pemilik" class="fi"
                           placeholder="Sesuai dengan nama pada KTP"
                           value="{{ old('nama_pemilik_rekening') }}" oninput="syncPreview()">
                    @error('nama_pemilik_rekening')<span class="fe">{{ $message }}</span>@enderror
                </div>

                <div class="form-footer">
                    <button type="button" onclick="bukaModal()" class="btn-lanjut">Lanjutkan</button>
                </div>

            </form>
        </div>

    </main>

    @include('layouts.partials.footer')

    <script>
        function syncPreview() {
            document.getElementById('preview-nama').textContent     = document.getElementById('input-nama').value || '—';
            document.getElementById('preview-nik').textContent      = document.getElementById('input-nik').value || '—';
            document.getElementById('preview-bank').textContent     = document.getElementById('input-bank').value || '—';
            document.getElementById('preview-rekening').textContent = document.getElementById('input-rekening').value || '—';
            document.getElementById('preview-pemilik').textContent  = document.getElementById('input-pemilik').value || '—';
        }
        function handleUpload(input, previewId, labelId) {
            const file = input.files[0];
            if (!file) return;
            const badge = document.getElementById(previewId);
            if (badge) badge.textContent = 'Diunggah ✓';
            const label = document.getElementById(labelId);
            if (label) label.textContent = '✓ ' + file.name;
        }
        function handleSelfie(input) {
            const file = input.files[0];
            if (!file) return;
            document.getElementById('preview-selfie').textContent = 'Diunggah ✓';
            document.querySelector('#label-btn-selfie .btn-foto').innerHTML = '<i class="bi bi-camera-fill"></i> Foto Ulang';
            document.getElementById('label-selfie').textContent = '✓ ' + file.name;
        }
        function bukaModal() {
            syncPreview();
            document.getElementById('modalKonfirmasi').classList.add('show');
        }
        function tutupModal() {
            document.getElementById('modalKonfirmasi').classList.remove('show');
        }
        document.getElementById('modalKonfirmasi').addEventListener('click', function(e) {
            if (e.target === this) tutupModal();
        });
    </script>

</body>
</html>