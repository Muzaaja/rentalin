<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Toko - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito+Sans:wght@800&family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        .step-form-card { background:#fff; border-radius:12px; box-shadow:0 2px 16px rgba(0,0,0,0.08); padding:36px 40px; max-width:900px; margin:0 auto; }
        .step-input { width:100%; border:1px solid #d1d5db; border-radius:8px; padding:12px 16px; font-size:0.95rem; color:#374151; outline:none; box-sizing:border-box; }
        .step-input:focus { border-color:#3b5fa0; }
        .step-label { font-weight:500; color:#374151; margin-bottom:6px; display:block; }
        .step-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:20px; }
        .step-group { display:flex; flex-direction:column; }
        .error-msg { color:#ef4444; font-size:0.8rem; margin-top:4px; }
        /* Stepper */
        .stepper { display:flex; align-items:center; gap:0; margin-bottom:40px; }
        .step-dot { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.95rem; }
        .step-dot.active { background:#3b5fa0; color:#fff; }
        .step-dot.inactive { background:#e5e7eb; color:#9ca3af; }
        .step-line { flex:1; height:2px; background:#d1d5db; }
        .step-line.done { background:#3b5fa0; }
        .step-item { display:flex; flex-direction:column; align-items:center; }
        /* Upload area */
        .upload-area { border:2px dashed #93c5fd; border-radius:10px; padding:32px 16px; text-align:center; background:#f0f7ff; cursor:pointer; position:relative; }
        .upload-area input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; }
        /* Privacy banner */
        .privacy-banner { background:#dbeafe; border-left:4px solid #3b82f6; padding:14px 18px; border-radius:8px; margin-bottom:28px; font-size:0.9rem; color:#1e40af; }
        /* Selfie checklist */
        .selfie-checks li { color:#16a34a; font-size:0.85rem; margin-bottom:4px; list-style:none; padding-left:0; }
        .selfie-checks li::before { content:"✓ "; }
        /* Modal overlay */
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:999; align-items:center; justify-content:center; }
        .modal-overlay.show { display:flex; }
        .modal-box { background:#fff; border-radius:14px; padding:32px 36px; max-width:520px; width:90%; box-shadow:0 8px 40px rgba(0,0,0,0.18); }
        .modal-section-title { font-size:0.75rem; font-weight:700; color:#6b7280; letter-spacing:0.08em; margin:16px 0 8px; }
        .modal-data-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f3f4f6; font-size:0.9rem; color:#374151; }
        .modal-data-row:last-child { border-bottom:none; }
        .badge-uploaded { background:#dcfce7; color:#16a34a; padding:3px 10px; border-radius:20px; font-size:0.78rem; font-weight:600; }
        .btn-cek-lagi { background:#fff; border:1.5px solid #3b5fa0; color:#3b5fa0; padding:12px 28px; border-radius:8px; font-weight:600; cursor:pointer; font-size:0.95rem; }
        .btn-kirim { background:#3b5fa0; color:#fff; border:none; padding:12px 28px; border-radius:8px; font-weight:600; cursor:pointer; font-size:0.95rem; display:inline-flex; align-items:center; gap:8px; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    {{-- ════ MODAL KONFIRMASI ════ --}}
    <div class="modal-overlay" id="modalKonfirmasi">
        <div class="modal-box">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:6px;">
                <div style="background:#e0e7ff; padding:8px; border-radius:8px;">📄</div>
                <div>
                    <div style="font-weight:700; font-size:1rem; color:#1e1e2e;">Konfirmasi data verifikasi</div>
                    <div style="font-size:0.82rem; color:#6b7280;">Pastikan semua data sudah benar sebelum dikirim</div>
                </div>
            </div>

            <div class="modal-section-title">IDENTITAS DIRI</div>
            <div style="border:1px solid #e5e7eb; border-radius:8px; padding:0 16px;">
                <div class="modal-data-row"><span>Nama lengkap</span><span id="preview-nama" style="color:#111;font-weight:500;"></span></div>
                <div class="modal-data-row"><span>NIK</span><span id="preview-nik" style="color:#111;font-weight:500;"></span></div>
                <div class="modal-data-row"><span>Foto KTP</span><span class="badge-uploaded" id="preview-ktp">Diunggah</span></div>
                <div class="modal-data-row"><span>Selfie dengan KTP</span><span class="badge-uploaded" id="preview-selfie">Diunggah</span></div>
            </div>

            <div class="modal-section-title">REKENING PENCAIRAN</div>
            <div style="border:1px solid #e5e7eb; border-radius:8px; padding:0 16px;">
                <div class="modal-data-row"><span>Bank</span><span id="preview-bank" style="color:#111;font-weight:500;"></span></div>
                <div class="modal-data-row"><span>Nomor rekening</span><span id="preview-rekening" style="color:#111;font-weight:500;"></span></div>
                <div class="modal-data-row"><span>Nama pemilik</span><span id="preview-pemilik" style="color:#111;font-weight:500;"></span></div>
            </div>

            <div style="display:flex; gap:12px; margin-top:28px; justify-content:center;">
                <button class="btn-cek-lagi" onclick="tutupModal()">✏️ Cek lagi</button>
                {{-- Tombol ini submit form asli --}}
                <button class="btn-kirim" onclick="document.getElementById('formStep2').submit()">
                    ▶ Ya, kirim sekarang
                </button>
            </div>
        </div>
    </div>

    <main class="page-container" style="padding:32px 40px; max-width:960px; margin:0 auto;">

        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('toko.step1') }}" style="text-decoration:none; color:#374151; font-size:1.2rem;">←</a>
            <h1 style="font-size:1.4rem; font-weight:700; color:#1e1e2e; margin:0;">Verifikasi Toko</h1>
        </div>

        {{-- Stepper --}}
        <div class="stepper">
            <div class="step-item">
                <div class="step-dot inactive">1</div>
                <span style="font-size:0.75rem; margin-top:6px; color:#9ca3af;">Data Toko</span>
            </div>
            <div class="step-line done"></div>
            <div class="step-item">
                <div class="step-dot active">2</div>
                <span style="font-size:0.75rem; margin-top:6px; color:#3b5fa0; font-weight:600;">Verifikasi</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-dot inactive">3</div>
                <span style="font-size:0.75rem; margin-top:6px; color:#9ca3af;">Selesai</span>
            </div>
        </div>

        {{-- Privacy Banner --}}
        <div class="privacy-banner">
            ℹ️ <strong>Pesan Privasi</strong><br>
            Data sensitif anda terenkripsi dan hanya digunakan untuk kebutuhan verifikasi. Rentalin tidak akan membagikan Kartu Identitas anda kepada pengguna lain.
        </div>

        <div class="step-form-card">

            @if ($errors->any())
                <div style="background:#fee2e2; color:#b91c1c; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:0.9rem;">
                    <ul style="margin:0; padding-left:16px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ID form untuk disubmit oleh tombol modal --}}
            <form id="formStep2" action="{{ route('toko.step2.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h2 style="font-size:1.1rem; font-weight:700; color:#1e1e2e; margin-bottom:20px;">Data Diri</h2>

                <div class="step-grid-2">
                    <div class="step-group">
                        <label class="step-label">NIK (nomor KTP)</label>
                        <input type="text" name="nik" id="input-nik" class="step-input"
                               placeholder="16 digit nomor KTP" maxlength="16"
                               value="{{ old('nik') }}"
                               oninput="syncPreview()">
                        @error('nik') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="step-group">
                        <label class="step-label">Nama lengkap sesuai KTP</label>
                        <input type="text" name="nama_lengkap_ktp" id="input-nama" class="step-input"
                               placeholder="Masukkan nama sesuai KTP"
                               value="{{ old('nama_lengkap_ktp') }}"
                               oninput="syncPreview()">
                        @error('nama_lengkap_ktp') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="step-grid-2" style="margin-bottom:32px;">
                    {{-- Upload KTP --}}
                    <div class="step-group">
                        <label class="step-label">Kartu Identitas</label>
                        <label class="upload-area">
                            <input type="file" name="foto_ktp" accept="image/*" onchange="handleUpload(this,'preview-ktp','label-ktp')">
                            <div id="label-ktp">
                                <div style="font-size:2rem; color:#93c5fd; margin-bottom:8px;">☁</div>
                                <div style="font-weight:600; color:#374151;">Unggah Foto Identitas Diri</div>
                                <div style="font-size:0.8rem; color:#9ca3af;">Klik untuk menggantikan dokumen</div>
                            </div>
                        </label>
                        @error('foto_ktp') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    {{-- Selfie --}}
                    <div class="step-group">
                        <label class="step-label">Verifikasi Selfie</label>
                        <div class="upload-area" style="position:relative;">
                            <ul class="selfie-checks" style="text-align:left; margin-bottom:16px; padding:0;">
                                <li>Pencahayaan bagus, tidak ada bayangan wajah</li>
                                <li>Wajah harus terlihat jelas, tidak memakai topi/kacamata</li>
                                <li>Wajah harus sesuai dengan kartu identitas</li>
                            </ul>
                            <label style="display:inline-flex; align-items:center; gap:8px; background:#3b5fa0; color:#fff; padding:10px 24px; border-radius:6px; cursor:pointer; font-weight:600; font-size:0.9rem;">
                                📷 Foto Ulang
                                <input type="file" name="foto_selfie" accept="image/*" style="display:none;" onchange="handleUpload(this,'preview-selfie','label-selfie')">
                            </label>
                            <div id="label-selfie" style="font-size:0.8rem; color:#6b7280; margin-top:8px;"></div>
                        </div>
                        @error('foto_selfie') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <h2 style="font-size:1.1rem; font-weight:700; color:#1e1e2e; margin-bottom:20px;">Rekening Pencairan</h2>

                <div class="step-grid-2">
                    <div class="step-group">
                        <label class="step-label">Nama Bank</label>
                        <input type="text" name="nama_bank" id="input-bank" class="step-input"
                               placeholder="Masukkan nama Bank"
                               value="{{ old('nama_bank') }}"
                               oninput="syncPreview()">
                        @error('nama_bank') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="step-group">
                        <label class="step-label">Nomor Rekening</label>
                        <input type="text" name="nomor_rekening" id="input-rekening" class="step-input"
                               placeholder="Masukkan nomor rekening"
                               value="{{ old('nomor_rekening') }}"
                               oninput="syncPreview()">
                        @error('nomor_rekening') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="step-group" style="margin-bottom:36px;">
                    <label class="step-label">Nama Pemilik Rekening</label>
                    <input type="text" name="nama_pemilik_rekening" id="input-pemilik" class="step-input"
                           placeholder="Sesuai dengan nama pada KTP"
                           value="{{ old('nama_pemilik_rekening') }}"
                           oninput="syncPreview()">
                    @error('nama_pemilik_rekening') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                {{-- Tombol Lanjutkan membuka modal, BUKAN langsung submit --}}
                <div style="text-align:center;">
                    <button type="button" onclick="bukaModal()"
                            style="background:#3b5fa0; color:#fff; padding:14px 60px;
                                   border:none; border-radius:8px; font-size:1rem;
                                   font-weight:600; cursor:pointer;">
                        Lanjutkan
                    </button>
                </div>

            </form>
        </div>

    </main>

    @include('layouts.partials.footer')

    <script>
        // Sync preview data ke modal
        function syncPreview() {
            document.getElementById('preview-nama').textContent    = document.getElementById('input-nama').value || '—';
            document.getElementById('preview-nik').textContent     = document.getElementById('input-nik').value || '—';
            document.getElementById('preview-bank').textContent    = document.getElementById('input-bank').value || '—';
            document.getElementById('preview-rekening').textContent = document.getElementById('input-rekening').value || '—';
            document.getElementById('preview-pemilik').textContent = document.getElementById('input-pemilik').value || '—';
        }

        // Handle tampilan nama file yang dipilih
        function handleUpload(input, previewId, labelId) {
            const file = input.files[0];
            if (!file) return;
            // Update badge di modal
            const badge = document.getElementById(previewId);
            if (badge) badge.textContent = 'Diunggah ✓';
            // Update label area upload
            const label = document.getElementById(labelId);
            if (label) label.textContent = '✓ ' + file.name;
        }

        function bukaModal() {
            syncPreview(); // pastikan data ter-update
            document.getElementById('modalKonfirmasi').classList.add('show');
        }

        function tutupModal() {
            document.getElementById('modalKonfirmasi').classList.remove('show');
        }

        // Tutup modal jika klik di luar box
        document.getElementById('modalKonfirmasi').addEventListener('click', function(e) {
            if (e.target === this) tutupModal();
        });
    </script>

</body>
</html>