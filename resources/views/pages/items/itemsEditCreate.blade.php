@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewakan Barang - Rentalin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F9FAFB; }
        /* Transisi untuk area deposit agar smooth saat disembunyikan/dimunculkan */
        #deposit-input-area { transition: all 0.3s ease-in-out; overflow: hidden; }
        .deposit-hidden { opacity: 0; max-height: 0; margin-bottom: 0 !important; padding-top: 0; padding-bottom: 0; border: none; }
        .deposit-visible { opacity: 1; max-height: 150px; margin-bottom: 2rem; }
    </style>
</head>
<body class="text-gray-800">

    @include('layouts.partials.navbar')

    <main class="max-w-5xl mx-auto px-4 py-8">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('items.index') }}" class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-200 transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Sewakan barang</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form id="form-item" action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-8">
                    <h2 class="text-base font-semibold text-gray-900 mb-1">Foto Barang <span class="text-red-500">*</span></h2>
                    <p class="text-sm text-gray-500 mb-4">Tambahkan hingga 5 foto. Foto pertama akan menjadi sampul wajib.</p>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        
                        <label class="relative aspect-square rounded-xl border-2 border-dashed border-blue-200 bg-blue-50/50 flex flex-col items-center justify-center cursor-pointer hover:bg-blue-50 transition overflow-hidden">
                            <img class="preview-img absolute inset-0 w-full h-full object-cover hidden">
                            <div class="upload-content flex flex-col items-center text-center p-2">
                                <span class="font-medium text-blue-500 mb-1 text-sm">Foto Utama</span>
                                <span class="text-[10px] text-gray-400">JPEG/PNG (Max 10MB)</span>
                            </div>
                            <input type="file" id="foto-utama" class="hidden" name="images[]" accept="image/jpeg, image/png" onchange="previewImage(this)">
                        </label>

                        @for ($i = 0; $i < 4; $i++)
                        <label class="relative aspect-square rounded-xl border-2 border-dashed border-blue-200 bg-blue-50/50 flex flex-col items-center justify-center cursor-pointer hover:bg-blue-50 transition overflow-hidden">
                            <img class="preview-img absolute inset-0 w-full h-full object-cover hidden">
                            <div class="upload-content flex flex-col items-center text-center p-2">
                                <svg class="w-8 h-8 text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-[10px] text-gray-400">JPEG/PNG (Max 10MB)</span>
                            </div>
                            <input type="file" class="hidden" name="images[]" accept="image/jpeg, image/png" onchange="previewImage(this)">
                        </label>
                        @endfor

                    </div>
                    <p id="error-foto" class="text-sm text-red-500 mt-2 hidden">Foto utama wajib diunggah.</p>
                </div>

                <hr class="border-gray-100 mb-8">

                <div class="mb-8">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">Kategori <span class="text-red-500">*</span></h2>
                    <div class="flex flex-wrap gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="category_id" value="1" class="peer hidden" checked>
                            <div class="px-4 py-2.5 rounded-full border border-gray-200 bg-white text-sm font-medium text-gray-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition flex items-center gap-2">
                                💻 Elektronik & Gadget
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="category_id" value="2" class="peer hidden">
                            <div class="px-4 py-2.5 rounded-full border border-gray-200 bg-white text-sm font-medium text-gray-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition flex items-center gap-2">
                                🎉 Pesta & Event
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="category_id" value="3" class="peer hidden">
                            <div class="px-4 py-2.5 rounded-full border border-gray-200 bg-white text-sm font-medium text-gray-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition flex items-center gap-2">
                                🏠 Rumah Tangga
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="category_id" value="4" class="peer hidden">
                            <div class="px-4 py-2.5 rounded-full border border-gray-200 bg-white text-sm font-medium text-gray-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition flex items-center gap-2">
                                ⚽ Hobi & Olahraga
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="category_id" value="5" class="peer hidden">
                            <div class="px-4 py-2.5 rounded-full border border-gray-200 bg-white text-sm font-medium text-gray-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition flex items-center gap-2">
                                👗 Fashion & Aksesoris
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-base font-semibold text-gray-900 mb-2">Nama Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Masukkan nama barang yang akan disewakan" required>
                </div>

                <div class="mb-8">
                    <label class="block text-base font-semibold text-gray-900 mb-2">Deskripsi Barang <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm resize-none" placeholder="Tuliskan spesifikasi, kondisi, dan keunggulan barang" required></textarea>
                </div>

                <hr class="border-gray-100 mb-8">

                <div class="mb-8">
                    <h2 class="text-base font-semibold text-gray-900 mb-1">Kelengkapan Barang <span class="text-red-500">*</span></h2>
                    <p class="text-sm text-gray-500 mb-4">Tambahkan item yang termasuk dalam paket sewa. Wajib mengisi minimal 1 kelengkapan.</p>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 cursor-move" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                            <input type="text" name="kelengkapan[]" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan detail kelengkapan" required>
                            <button type="button" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="text-blue-600 text-sm font-medium flex items-center gap-1 hover:text-blue-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Kelengkapan
                    </button>
                </div>

                <hr class="border-gray-100 mb-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-base font-semibold text-gray-900 mb-2">Harga Sewa per Hari <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                            <input type="number" name="price_per_day" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm" placeholder="Tentukan harga sewa" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-base font-semibold text-gray-900 mb-2">Persentase Denda Terlambat</label>
                        <div class="relative">
                            <input type="number" name="late_fee_percentage" class="w-full pl-4 pr-16 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm" placeholder="Tentukan denda keterlambatan" min="0" max="100" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">% / hari</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Terapkan Deposit</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Jaminan uang kembali jika barang rusak/hilang.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle-deposit" name="has_deposit" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div id="deposit-input-area" class="deposit-visible">
                    <label class="block text-base font-semibold text-gray-900 mb-2">Nominal Deposit <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                        <input type="number" id="deposit_amount" name="deposit_amount" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm" placeholder="Tentukan nominal deposit" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                </div>

                <hr class="border-gray-100 mb-8">

                <div class="mb-10">
                    <h2 class="text-base font-semibold text-gray-900 mb-1">Metode Serah Terima <span class="text-red-500">*</span></h2>
                    <p class="text-sm text-gray-500 mb-4">Pilih lokasi ketersediaan barang untuk pengambilan atau pengiriman. Pemilik dapat memilih lebih dari satu metode.</p>
                    
                    <div class="flex items-center gap-6 mb-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="is_cod" name="is_cod" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                            <span class="text-sm text-gray-700">COD (Ambil di tempat)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="is_delivery" name="is_delivery" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Dikirim melalui kurir</span>
                        </label>
                    </div>
                    <p id="error-metode" class="text-sm text-red-500 mb-4 hidden">Minimal pilih 1 metode serah terima.</p>

                    <div class="relative">
                        <select id="kecamatan-select" name="kecamatan" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm bg-white" required>
                            <option value="">Memuat data wilayah...</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="bg-[#34699A] hover:bg-[#28537a] text-white font-semibold py-3 px-12 rounded-xl transition shadow-sm w-full md:w-auto min-w-[200px]">
                        Sewakan
                    </button>
                </div>

            </form>
        </div>
    </main>

    @include('layouts.partials.footer')

    <script>
        // --- Fungsi Global Pratinjau Gambar ---
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const label = input.closest('label');
                    const img = label.querySelector('.preview-img');
                    const content = label.querySelector('.upload-content');
                    
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    if(content) content.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
                
                // Hilangkan pesan error jika gambar sudah diisi
                if(input.id === 'foto-utama') {
                    document.getElementById('error-foto').classList.add('hidden');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', async function() {
            
            // --- Logika Validasi Submit Form ---
            const formItem = document.getElementById('form-item');
            formItem.addEventListener('submit', function(e) {
                let isValid = true;

                // Validasi Foto Utama (Harus diisi)
                const fotoUtama = document.getElementById('foto-utama');
                const errorFoto = document.getElementById('error-foto');
                if (fotoUtama.files.length === 0) {
                    errorFoto.classList.remove('hidden');
                    isValid = false;
                } else {
                    errorFoto.classList.add('hidden');
                }

                // Validasi Metode Serah Terima (Minimal 1 dipilih)
                const isCod = document.getElementById('is_cod').checked;
                const isDelivery = document.getElementById('is_delivery').checked;
                const errorMetode = document.getElementById('error-metode');
                if (!isCod && !isDelivery) {
                    errorMetode.classList.remove('hidden');
                    isValid = false;
                } else {
                    errorMetode.classList.add('hidden');
                }

                // Jika ada yang tidak valid, cegah form dikirim
                if (!isValid) {
                    e.preventDefault();
                    // Scroll ke atas agar pengguna melihat pesan error foto
                    if(fotoUtama.files.length === 0) {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
            });

            // --- Logika Toggle Deposit ---
            const toggleDeposit = document.getElementById('toggle-deposit');
            const depositArea = document.getElementById('deposit-input-area');
            const depositInput = document.getElementById('deposit_amount');

            toggleDeposit.addEventListener('change', function() {
                if(this.checked) {
                    depositArea.className = 'deposit-visible';
                    depositInput.required = true;
                } else {
                    depositArea.className = 'deposit-hidden';
                    depositInput.required = false;
                    depositInput.value = ''; // Kosongkan nilai saat disembunyikan
                }
            });

            // --- Logika Dynamic Kelengkapan Barang ---
            const kelengkapanContainer = document.querySelector('.space-y-3.mb-4'); 
            const btnTambahKelengkapan = Array.from(document.querySelectorAll('button')).find(el => el.textContent.includes('Tambah Kelengkapan'));

            if (btnTambahKelengkapan && kelengkapanContainer) {
                btnTambahKelengkapan.addEventListener('click', function() {
                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-3 mt-3';
                    row.innerHTML = `
                        <svg class="w-5 h-5 text-gray-400 cursor-move" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                        <input type="text" name="kelengkapan[]" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan detail kelengkapan" required>
                        <button type="button" class="btn-hapus-kelengkapan text-red-500 hover:bg-red-50 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    `;
                    kelengkapanContainer.appendChild(row);
                });

                kelengkapanContainer.addEventListener('click', function(e) {
                    const btnHapus = e.target.closest('.btn-hapus-kelengkapan');
                    if (btnHapus) {
                        btnHapus.parentElement.remove();
                    }
                });
            }

            // --- Logika API Wilayah ---
            const selectKecamatan = document.getElementById('kecamatan-select');
            const bandungRayaIds = ['3204', '3217', '3273', '3277'];
            const sumedangId = '3211';
            const wilayahSumedangDiizinkan = ['JATINANGOR']; 

            try {
                let semuaKecamatan = [];

                const fetchPromises = bandungRayaIds.map(id => 
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`)
                    .then(res => res.json())
                );
                
                const hasilBandungRaya = await Promise.all(fetchPromises);
                
                hasilBandungRaya.forEach(data => {
                    semuaKecamatan = semuaKecamatan.concat(data);
                });

                const resSumedang = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${sumedangId}.json`);
                const dataSumedang = await resSumedang.json();
                
                const filterSumedang = dataSumedang.filter(kecamatan => 
                    wilayahSumedangDiizinkan.includes(kecamatan.name.toUpperCase())
                );
                
                semuaKecamatan = semuaKecamatan.concat(filterSumedang);
                semuaKecamatan.sort((a, b) => a.name.localeCompare(b.name));

                selectKecamatan.innerHTML = '<option value="">Pilih kecamatan</option>';
                
                semuaKecamatan.forEach(kecamatan => {
                    const namaFormat = kecamatan.name.toLowerCase().replace(/\b\w/g, s => s.toUpperCase());
                    const option = document.createElement('option');
                    option.value = namaFormat; 
                    option.textContent = namaFormat;
                    selectKecamatan.appendChild(option);
                });

            } catch (error) {
                console.error('Gagal mengambil data API wilayah:', error);
                selectKecamatan.innerHTML = '<option value="">Gagal memuat wilayah. Silakan refresh halaman.</option>';
            }
        });
    </script>
</body>
</html>