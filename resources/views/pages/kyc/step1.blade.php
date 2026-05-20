<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rentalin - Verifikasi Identitas</title>
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <style>
    body { background-color: #F8FAFC; margin: 0; font-family: sans-serif; }
    .header-border { border-bottom: 4px solid #E2E8F0; background-color: #FFFFFF; padding: 20px 0; }
    .kyc-card { background-color: #FFFFFF; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 40px; margin-bottom: 60px; }
    .req-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px; }
    .req-list li { display: flex; align-items: flex-start; gap: 12px; font-size: 15px; color: #000000; font-weight: 500; line-height: 1.5; }
    .check-icon { min-width: 22px; height: 22px; background-color: #34699A; border-radius: 50%; color: #FFFFFF; display: flex; justify-content: center; align-items: center; font-size: 12px; font-weight: bold; margin-top: 2px; }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="header-border">
    <div class="container" style="display: flex; align-items: center; gap: 16px;">
      <a href="profile.html" style="text-decoration: none; color: #000; font-size: 24px; border: 1px solid #000; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">←</a>
      <h1 style="margin: 0; font-size: 24px; font-weight: 700;">Verifikasi Identitas</h1>
    </div>
  </header>

  <main class="container" style="max-width: 900px; padding-top: 40px;">
    
    <!-- Stepper (Langkah 1 Aktif) -->
    <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 80px;">
        <div style="display: flex; flex-direction: column; align-items: center; position: relative;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background-color: #34699A; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; z-index: 2;">1</div>
            <span style="color: #34699A; font-weight: 700; font-size: 20px; position: absolute; top: 75px; width: max-content;">Kartu Identitas</span>
        </div>
        <div style="width: 250px; height: 0; border-top: 2px dashed #000000; margin: 0 15px; transform: translateY(-8px);"></div>
        <div style="display: flex; flex-direction: column; align-items: center; position: relative;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background-color: #A0AABF; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; z-index: 2;">2</div>
            <span style="color: #A0AABF; font-weight: 700; font-size: 20px; position: absolute; top: 75px; width: max-content;">Pemindaian Wajah</span>
        </div>
    </div>

    <!-- Card Verifikasi -->
    <section class="kyc-card">
      <h2 style="font-size: 32px; font-weight: 700; margin-top: 0; margin-bottom: 12px;">Unggah Identitas Anda</h2>
      <p style="font-size: 16px; color: #000000; margin-bottom: 32px; font-weight: 500;">Pastikan kartu identitas Anda valid dan detailnya terbaca dengan jelas.</p>
      
      <div style="display: grid; grid-template-columns: 1.3fr 1fr; gap: 50px;">
        
        <!-- Kiri: Upload Box -->
        <div onclick="document.getElementById('file-upload-1').click();" style="background-color: #E2E8F0; border: 2px dashed #34699A; border-radius: 8px; padding: 60px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; min-height: 220px; text-align: center;">
          <input type="file" id="file-upload-1" style="display: none;">
          <img src="{{ asset('assets/icons/image-add.png') }}" alt="Add" style="width: 40px; margin-bottom: 16px;">
          <p style="font-size: 18px; font-weight: 700; color: #000000; margin: 0 0 8px 0;">Ambil Foto atau Unggah Kartu Identitas</p>
          <span style="font-size: 13px; color: #64748B; font-style: italic;">JPEG, PNG, or PDF (Max 10MB)</span>
        </div>

        <!-- Kanan: Persyaratan & Tombol -->
        <div style="display: flex; flex-direction: column; justify-content: space-between;">
          <div>
            <h3 style="font-size: 22px; font-weight: 700; margin-top: 0; margin-bottom: 24px;">Daftar Persyaratan</h3>
            <ul class="req-list">
              <li><div class="check-icon">✔</div> Foto jernih dengan semua teks terbaca jelas</li>
              <li><div class="check-icon">✔</div> Keempat sudut kartu terlihat</li>
              <li><div class="check-icon">✔</div> Tidak ada pantulan cahaya atau bayangan</li>
            </ul>
          </div>
          
          <div style="text-align: right; margin-top: 40px;">
            <button onclick="window.location.href='kyc-step2.html';" style="background-color: #34699A; color: #FFFFFF; border: none; padding: 12px 32px; font-size: 16px; font-weight: 600; border-radius: 8px; cursor: pointer; transition: 0.2s;">Konfirmasi</button>
          </div>
        </div>

      </div>
    </section>
  </main>
</body>
</html>