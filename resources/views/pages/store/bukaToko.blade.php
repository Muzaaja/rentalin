<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buka Toko - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito+Sans:wght@800&family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
<body>

    @include('layouts.partials.navbar')

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

        <a href="{{ route('toko.step1') }}"
           style="display:inline-flex; align-items:center; gap:10px;
                  background:#3b5fa0; color:#fff; padding:16px 40px;
                  border-radius:8px; font-size:1.1rem; font-weight:600;
                  text-decoration:none; transition:background 0.2s;">
            Buka Toko &nbsp;→
        </a>

    </main>

    @include('layouts.partials.footer')

</body>
</html>