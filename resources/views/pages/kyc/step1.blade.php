@extends('layouts.app')

@section('content')

<style>
body {
    background-color: #F8FAFC;
}

.header-border {
    border-bottom: 4px solid #E2E8F0;
    background-color: #FFFFFF;
    padding: 20px 0;
}

.kyc-card {
    background-color: #FFFFFF;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 40px;
    margin-bottom: 60px;
}

.req-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.req-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 15px;
    color: #000;
    font-weight: 500;
    line-height: 1.5;
}

.check-icon {
    min-width: 22px;
    height: 22px;
    background-color: #34699A;
    border-radius: 50%;
    color: white;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:12px;
}

.upload-preview{
    margin-top:15px;
    max-width:250px;
    border-radius:8px;
    display:none;
}
</style>

<header class="header-border">
    <div class="container" style="display:flex;align-items:center;gap:16px;">
        <a href="{{ route('profile.edit') }}"
           style="text-decoration:none;color:#000;font-size:24px;border:1px solid #000;border-radius:50%;width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
            ←
        </a>

        <h1 style="margin:0;font-size:24px;font-weight:700;">
            Verifikasi Identitas
        </h1>
    </div>
</header>

<main class="container" style="max-width:900px;padding-top:40px;">

    <div style="display:flex;align-items:center;justify-content:center;margin-bottom:80px;">

        <div style="display:flex;flex-direction:column;align-items:center;position:relative;">
            <div style="width:64px;height:64px;border-radius:50%;background:#34699A;color:#fff;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:bold;">
                1
            </div>

            <span style="color:#34699A;font-weight:700;font-size:20px;position:absolute;top:75px;width:max-content;">
                Kartu Identitas
            </span>
        </div>

        <div style="width:250px;border-top:2px dashed #000;margin:0 15px;transform:translateY(-8px);"></div>

        <div style="display:flex;flex-direction:column;align-items:center;position:relative;">
            <div style="width:64px;height:64px;border-radius:50%;background:#A0AABF;color:#fff;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:bold;">
                2
            </div>

            <span style="color:#A0AABF;font-weight:700;font-size:20px;position:absolute;top:75px;width:max-content;">
                Pemindaian Wajah
            </span>
        </div>

    </div>

    <section class="kyc-card">

        <form method="POST"
              action="{{ route('kyc.step1.store') }}"
              enctype="multipart/form-data">

            @csrf

            <h2 style="font-size:32px;font-weight:700;margin-top:0;">
                Unggah Identitas Anda
            </h2>

            <p style="font-size:16px;font-weight:500;margin-bottom:32px;">
                Pastikan kartu identitas Anda valid dan detailnya terbaca dengan jelas.
            </p>

            <div style="display:grid;grid-template-columns:1.3fr 1fr;gap:50px;">

                <div>

                    <div onclick="document.getElementById('identity_photo').click();"
                         style="background:#E2E8F0;border:2px dashed #34699A;border-radius:8px;padding:60px 20px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;min-height:220px;text-align:center;">

                        <input type="file"
                               id="identity_photo"
                               name="identity_photo"
                               accept="image/*"
                               required
                               style="display:none;"
                               onchange="previewKtp(this)">

                        <div style="font-size:50px;">📄</div>

                        <p style="font-size:18px;font-weight:700;">
                            Ambil Foto atau Unggah Kartu Identitas
                        </p>

                        <span style="font-size:13px;color:#64748B;">
                            JPEG, PNG (Max 10MB)
                        </span>

                        <img id="preview-ktp" class="upload-preview">
                    </div>

                    @error('identity_photo')
                    <p style="color:red;margin-top:10px;">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

                <div>

                    <h3 style="font-size:22px;font-weight:700;">
                        Daftar Persyaratan
                    </h3>

                    <ul class="req-list">
                        <li><div class="check-icon">✔</div> Foto jernih dengan semua teks terbaca jelas</li>
                        <li><div class="check-icon">✔</div> Keempat sudut kartu terlihat</li>
                        <li><div class="check-icon">✔</div> Tidak ada pantulan cahaya atau bayangan</li>
                    </ul>

                    <div style="text-align:right;margin-top:40px;">

                        <button type="submit"
                                style="background:#34699A;color:#fff;border:none;padding:12px 32px;border-radius:8px;cursor:pointer;">
                            Konfirmasi
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </section>

</main>

<script>
function previewKtp(input){
    const file = input.files[0];
    if(!file) return;

    const reader = new FileReader();

    reader.onload = function(e){
        const img = document.getElementById('preview-ktp');
        img.src = e.target.result;
        img.style.display = 'block';
    }

    reader.readAsDataURL(file);
}
</script>

@endsection