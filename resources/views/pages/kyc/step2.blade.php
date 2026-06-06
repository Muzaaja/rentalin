@extends('layouts.app')

@section('content')

<main style="max-width:1200px;margin:0 auto;padding:50px 20px;">

    {{-- STEP INDICATOR --}}
    <div style="
        display:flex;
        justify-content:center;
        align-items:center;
        margin-bottom:100px;
    ">

        <div style="text-align:center;">
            <div style="
                width:72px;
                height:72px;
                background:#34699A;
                color:white;
                border-radius:50%;
                display:flex;
                justify-content:center;
                align-items:center;
                font-size:32px;
                font-weight:700;
            ">
                1
            </div>

            <div style="
                margin-top:15px;
                font-size:22px;
                font-weight:700;
                color:#34699A;
            ">
                Kartu Identitas
            </div>
        </div>

        <div style="
            width:350px;
            border-top:2px dashed #666;
            margin:0 30px;
        "></div>

        <div style="text-align:center;">
            <div style="
                width:72px;
                height:72px;
                background:#34699A;
                color:white;
                border-radius:50%;
                display:flex;
                justify-content:center;
                align-items:center;
                font-size:32px;
                font-weight:700;
            ">
                2
            </div>

            <div style="
                margin-top:15px;
                font-size:22px;
                font-weight:700;
                color:#34699A;
            ">
                Pemindaian Wajah
            </div>
        </div>

    </div>

    {{-- CARD --}}
    <div style="
        background:white;
        border-radius:12px;
        box-shadow:0 2px 10px rgba(0,0,0,.1);
        padding:40px;
        max-width:900px;
        margin:auto;
    ">

        <form
            method="POST"
            action="{{ route('kyc.step2.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <h2 style="
                font-size:32px;
                font-weight:800;
                margin-bottom:10px;
            ">
                Unggah Foto Selfie Anda
            </h2>

            <p style="
                margin-bottom:35px;
                color:#333;
            ">
                Pastikan kartu identitas Anda valid dan detailnya terbaca dengan jelas.
            </p>

            <div style="
                display:grid;
                grid-template-columns:1.2fr .8fr;
                gap:30px;
            ">

                {{-- UPLOAD --}}
                <div>

                    <div
                        onclick="document.getElementById('selfie_photo').click();"
                        style="
                            border:2px dashed #34699A;
                            background:#e5e7eb;
                            border-radius:8px;
                            min-height:250px;
                            cursor:pointer;
                            display:flex;
                            flex-direction:column;
                            justify-content:center;
                            align-items:center;
                            text-align:center;
                        "
                    >

                        <input
                            type="file"
                            id="selfie_photo"
                            name="selfie_photo"
                            accept="image/*"
                            required
                            style="display:none;"
                            onchange="previewSelfie(this)"
                        >

                        <div style="font-size:50px;">
                            📷
                        </div>

                        <div style="
                            font-size:18px;
                            font-weight:700;
                            margin-top:15px;
                        ">
                            Ambil Foto atau Unggah Foto Anda
                        </div>

                        <div style="
                            font-size:12px;
                            color:#666;
                        ">
                            JPEG, PNG, atau PDF (Max 10MB)
                        </div>

                        <img
                            id="preview-selfie"
                            style="
                                display:none;
                                width:100%;
                                max-height:250px;
                                object-fit:cover;
                                border-radius:8px;
                                margin-top:15px;
                            "
                        >
                    </div>

                </div>

                {{-- REQUIREMENT --}}
                <div>

                    <h3 style="
                        font-size:22px;
                        font-weight:700;
                        margin-bottom:25px;
                    ">
                        Daftar Persyaratan
                    </h3>

                    <ul style="
                        list-style:none;
                        padding:0;
                        line-height:2;
                    ">
                        <li>✔ Pastikan pencahayaan bagus</li>
                        <li>✔ Lepaskan kacamata/topi</li>
                        <li>✔ Foto selfie sesuai dengan dokumen identitas Anda</li>
                    </ul>

                    <div style="text-align:right;margin-top:40px;">

                        <button
                            type="submit"
                            style="
                                background:#34699A;
                                color:white;
                                border:none;
                                border-radius:8px;
                                padding:10px 25px;
                                cursor:pointer;
                            "
                        >
                            Konfirmasi
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</main>

@endsection