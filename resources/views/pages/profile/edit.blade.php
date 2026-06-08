@extends('layouts.app')

@section('content')

<div class="profile-page">

<div class="container profile-layout">

    {{-- ================= SIDEBAR ================= --}}

    <aside class="profile-sidebar">

        <div class="sidebar-profile">

           <img
                id="sidebar-avatar-img"
                src="{{ $user->avatar
                    ? asset('storage/'.$user->avatar)
                    : asset('assets/img/profile/user-photo-profile.png') }}"
                class="avatar-lg"
                alt="Avatar">

            <h3>
                {{ trim(($user->first_name ?? '').' '.($user->last_name ?? ''))
                    ?: $user->name }}
            </h3>

            <small>
                {{ $user->email }}
            </small>

        </div>

        <div class="sidebar-menu">

            <a
                href="{{ route('profile.edit') }}"
                class="menu-btn active">
                👤 Profil
            </a>

            <a
                href="{{ route('riwayat.transaksi.penyewa') }}"
                class="menu-btn">
                📜 Riwayat
            </a>

            <a
                href="{{ route('profile.edit') }}"
                class="menu-btn">
                ⚙ Pengaturan
            </a>

            <a href="{{ route('profile.cicilan.index') }}" class="menu-btn">
                💳 Cicilan
            </a>

            <form
                action="{{ route('logout') }}"
                method="POST">

                @csrf

                <button
                    type="submit"
                    class="menu-btn logout-btn">
                    🚪 Keluar
                </button>

            </form>

        </div>

    </aside>

    {{-- ================= CONTENT ================= --}}

    <section class="profile-content">

        <div class="profile-card">

            <div class="card-header-flex">
                <div>
                    <h2>Pengaturan Akun</h2>
                    <small>Kelola informasi pribadi akun Rentalin Anda</small>
                </div>
                <button
                    type="button"
                    id="editProfileBtn"
                    class="menu-btn filled">

                    ✏ Edit Details
                </button>
            </div>

            @if(session('status')==='profile-updated')
                <div class="alert alert-success">
                    Profil berhasil diperbarui.
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') </form>

                <div class="form-grid">

                    {{-- Nama Lengkap (Gabungan) --}}
                    <div class="form-group full">
                        <label>Nama Lengkap</label>
                        <input type="text" class="editable" readonly name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="form-group full">
                        <label>Alamat Email</label>
                        <input type="email" class="editable" readonly name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    {{-- Nomor HP --}}
                    <div class="form-group full">
                        <label>Nomor HP</label>
                        <input type="text" class="editable" readonly name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group full">
                        <label>Alamat Lengkap</label>
                        <textarea class="editable" readonly name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                    </div>

                    {{-- Provinsi (Statis Jawa Barat) --}}
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select class="editable" disabled name="province" id="provinceSelect" readonly style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background-color: #f9fafb; color: #374151; outline: none; box-sizing: border-box; height: 42px;">
                            <option value="JAWA BARAT" selected>Jawa Barat</option>
                        </select>
                    </div>

                    {{-- Kota (Dinamis API Bandung Raya) --}}
                    <div class="form-group">
                        <label>Kota/Kabupaten</label>
                        <select class="editable" disabled name="city" id="citySelect" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background-color: #f9fafb; color: #374151; outline: none; box-sizing: border-box; height: 42px;">
                            <option value="">Memuat data...</option>
                        </select>
                    </div>

                    {{-- Kode Pos --}}
                    <div class="form-group">
                        <label>Kode Pos</label>
                        <input type="text" class="editable" readonly name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
                    </div>

                    {{-- Upload Foto Profil (Disembunyikan secara default, muncul saat klik Edit) --}}
                    <div class="form-group full" id="avatarUploadGroup" style="display: none;">
                        <label>Ubah Foto Profil</label>
                        <input type="file" name="avatar" id="avatarInput" class="editable" style="background-color: #ffffff; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px; width: 100%;" accept="image/jpeg, image/png, image/jpg" onchange="previewAvatar(this)">
                        <small style="color: #6b7280; margin-top: 4px; display: block;">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG/PNG. Maks: 2MB.</small>
                    </div>

                </div>

                <div id="saveContainer" style="display:none;margin-top:25px;">
                    <button type="submit" class="menu-btn filled">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>

        {{-- ================= VERIFIKASI IDENTITAS ================= --}}

        <div class="profile-card">

            <div class="card-header-flex">
                <h2>Verifikasi Identitas</h2>
                @if($user->kyc)
                    @if($user->kyc->status === 'approved')
                        <span class="status-badge" style="background-color: #DEF7EC; color: #03543F; border: 1px solid #31C48D;">
                            ✔ Terverifikasi
                        </span>
                    @elseif($user->kyc->status === 'pending')
                        <span class="status-badge" style="background-color: #FEF3C7; color: #92400E; border: 1px solid #FACA15;">
                            ⏳ Menunggu Review
                        </span>
                    @elseif($user->kyc->status === 'rejected')
                        <span class="status-badge" style="background-color: #FDE8E8; color: #9B1C1C; border: 1px solid #F8B4B4;">
                            ✖ Ditolak
                        </span>
                    @endif
                @else
                    <span class="status-badge" style="background-color: #F3F4F6; color: #4B5563;">
                        Belum Verifikasi
                    </span>
                @endif
            </div>

            <div class="verifikasi-grid">
                {{-- FOTO KTP --}}
                <div class="upload-box">
                    <h4>Kartu Identitas</h4>
                    @if($user->kyc && $user->kyc->photo_ktp)
                        <img src="{{ asset('storage/'.$user->kyc->photo_ktp) }}" class="preview-image" alt="KTP">
                    @else
                        <div class="upload-placeholder">
                            <div class="upload-icon">☁️</div>
                            <strong>Belum ada KTP</strong>
                        </div>
                    @endif
                </div>

                {{-- SELFIE --}}
                <div class="upload-box">
                    <h4>Verifikasi Wajah</h4>
                    @if($user->kyc && $user->kyc->selfie)
                        <img src="{{ asset('storage/'.$user->kyc->selfie) }}" class="preview-image" alt="Selfie">
                    @else
                        <div class="selfie-guide">
                            <ul>
                                <li>✔ Wajah terlihat jelas</li>
                                <li>✔ Tidak memakai masker</li>
                                <li>✔ Tidak memakai topi</li>
                                <li>✔ Sesuai dengan KTP</li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            {{-- PESAN & AKSI DINAMIS --}}
            <div class="info-box" style="margin-top: 20px;">
                @if(!$user->kyc)
                    <strong>Pesan Sistem</strong>
                    <p>Silakan lengkapi dokumen verifikasi identitas Anda agar dapat mulai menyewa barang di Rentalin. Seluruh data dijaga dengan sistem keamanan terenkripsi.</p>
                @elseif($user->kyc->status === 'pending')
                    <strong>Sedang Diproses</strong>
                    <p>Dokumen Anda telah berhasil dikirim dan saat ini sedang dalam antrean pengecekan oleh tim Admin. Mohon menunggu.</p>
                @elseif($user->kyc->status === 'approved')
                    <strong>Verifikasi Berhasil</strong>
                    <p>Identitas Anda telah diverifikasi. Seluruh data identitas dijaga dengan sistem keamanan terenkripsi dan tidak dibagikan ke pihak lain.</p>
                @elseif($user->kyc->status === 'rejected')
                    <strong style="color: #9B1C1C;">Verifikasi Ditolak</strong>
                    
                    @if($user->kyc->notes)
                        <p style="color: #9B1C1C; margin-top: 4px; font-weight: 600;">
                            Alasan Penolakan:
                        </p>
                        <p style="color: #9B1C1C; margin-top: 2px; background-color: #FDF2F2; padding: 8px 12px; border-left: 4px solid #F8B4B4; border-radius: 4px;">
                            {{ $user->kyc->notes }}
                        </p>
                        <p style="color: #4B5563; font-size: 13px; margin-top: 8px;">
                            Silakan lakukan pengajuan ulang verifikasi dengan memperbaiki dokumen sesuai dengan catatan di atas.
                        </p>
                    @else
                        <p style="color: #9B1C1C; margin-top: 4px;">
                            Dokumen yang Anda unggah tidak memenuhi syarat (buram atau tidak sesuai). Silakan unggah ulang dokumen yang lebih jelas.
                        </p>
                    @endif
                @endif
            </div>

            {{-- Tombol Aksi Verifikasi Bawah --}}
            @if(!$user->kyc || $user->kyc->status === 'rejected')
                <div class="verify-action" style="margin-top: 20px;">
                    <a href="{{ route('kyc.step1') }}" 
                       style="display: inline-block; text-align: center; background-color: #EBF4FF; color: #34699A; border: 1px solid #BFDBFE; padding: 10px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: background-color 0.2s;"
                       onmouseover="this.style.backgroundColor='#DBEAFE'"
                       onmouseout="this.style.backgroundColor='#EBF4FF'">
                        {{ !$user->kyc ? 'Lengkapi Verifikasi' : 'Ajukan Ulang Verifikasi' }}
                    </a>
                </div>
            @endif

        </div>

    </section>

</div>

</div>

{{-- ================= JAVASCRIPT ================= --}}

<script>
document.addEventListener("DOMContentLoaded", function() {

    // 1. Logika Tombol Edit Details
    const editBtn = document.getElementById("editProfileBtn");
    const saveContainer = document.getElementById("saveContainer");
    const inputs = document.querySelectorAll(".editable");
    const avatarGroup = document.getElementById("avatarUploadGroup");

    if(editBtn) {
        editBtn.addEventListener("click", function() {
            inputs.forEach(function(input) {
                // Biarkan provinsi tetap terkunci
                if(input.id !== 'provinceSelect') {
                    input.removeAttribute("readonly");
                    input.removeAttribute("disabled");
                    input.style.backgroundColor = "#ffffff"; // Ubah menjadi putih saat mode edit
                }
            });
            
            // Munculkan kolom upload foto
            if(avatarGroup) avatarGroup.style.display = "block";
            
            saveContainer.style.display = "block";
            editBtn.style.display = "none";
        });
    }

    // 2. Logika Fetch API Wilayah Bandung Raya
    const citySelect = document.getElementById('citySelect');
    const savedCity = "{{ old('city', $user->city) }}";
    
    const bandungRaya = [
        'KOTA BANDUNG', 
        'KABUPATEN BANDUNG', 
        'KABUPATEN BANDUNG BARAT', 
        'KOTA CIMAHI', 
        'KABUPATEN SUMEDANG'
    ];

    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/32.json')
        .then(response => response.json())
        .then(regencies => {
            citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
            
            regencies.forEach(regency => {
                if (bandungRaya.includes(regency.name)) {
                    let option = document.createElement('option');
                    option.value = regency.name;
                    option.text = regency.name;
                    
                    if(savedCity && regency.name.toUpperCase() === savedCity.toUpperCase()) {
                        option.selected = true;
                    }
                    citySelect.appendChild(option);
                }
            });
        })
        .catch(error => {
            console.error('Error fetching cities:', error);
            citySelect.innerHTML = '<option value="">Gagal memuat data kota</option>';
        });
});

// 3. Fungsi Pratinjau Foto Langsung ke Sidebar
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Ubah gambar di sidebar secara langsung
            document.getElementById('sidebar-avatar-img').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection