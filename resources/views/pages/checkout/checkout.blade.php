<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Rentalin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

    @include('layouts.partials.navbar')

    <main class="max-w-[1100px] mx-auto px-[20px] sm:px-[40px] py-[30px]">
        
        <div class="flex items-center gap-3 mb-6">
            <a href="javascript:history.back()" class="w-8 h-8 flex items-center justify-center rounded-full border border-[#D1D5DB] bg-white hover:bg-gray-50 text-gray-700 transition">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-[22px] sm:text-[26px] font-bold text-gray-900">Checkout</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-6">
            
            <div class="space-y-6">
                <div class="bg-white rounded-[10px] border border-[#C3DAFE] p-[20px] sm:p-[24px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                    <div class="flex flex-col sm:flex-row gap-6 mb-6">
                        @php
                            $images = $rental->item->image ?? [];
                            $img = is_array($images) && count($images) ? $images[0] : null;
                            $days = $rental->start_date->diffInDays($rental->end_date) + 1;
                            $deposit = $rental->item->has_deposit ? $rental->item->deposit_amount : 0;
                            $total = $payment->amount + $deposit;
                        @endphp
                        
                        @if($img)
                            <img src="{{ asset('storage/'.$img) }}" class="w-full sm:w-[180px] h-[140px] object-cover rounded-[8px]" alt="{{ $rental->item->name }}">
                        @else
                            <div class="w-full sm:w-[180px] h-[140px] bg-gray-200 rounded-[8px] flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                        
                        <div class="flex-1">
                            <h2 class="text-[16px] sm:text-[18px] font-bold text-gray-900 leading-tight mb-1">{{ $rental->item->name }}</h2>
                            <p class="text-[13px] text-gray-500 mb-4">Disewakan oleh: <span class="text-gray-900 font-semibold">{{ $rental->owner->name }}</span></p>

                            <table class="text-[13px] text-gray-600 w-full">
                                <tr>
                                    <td class="pb-2 pr-4 whitespace-nowrap">Jadwal sewa</td>
                                    <td class="pb-2 font-medium text-gray-900">: {{ $rental->start_date->format('d M Y') }} - {{ $rental->end_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="pb-2 pr-4 whitespace-nowrap">Durasi</td>
                                    <td class="pb-2 font-medium text-gray-900">: {{ $days }} hari</td>
                                </tr>
                                <tr>
                                    <td class="pb-2 pr-4 whitespace-nowrap">Metode penyerahan</td>
                                    <td class="pb-2 font-medium text-gray-900">: {{ strtoupper($rental->delivery_method ?? 'COD') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr class="border-[#E5E7EB] mb-4">
                    
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="checkbox" id="tnc-checkbox" class="w-5 h-5 rounded border-gray-300 text-[#34699A] focus:ring-[#34699A] cursor-pointer">
                        <span class="text-[13px] text-gray-700">Saya telah membaca dan menyetujui 
                            <a href="{{ route('items.show', $rental->item->id) }}" target="_blank" class="text-[#34699A] hover:underline font-semibold">Aturan dan Kebijakan Sewa</a>
                        </span>
                    </label>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-[10px] border border-[#C3DAFE] p-[20px] sm:p-[24px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                    <h3 class="font-bold text-[18px] mb-4 text-gray-900">Pembayaran</h3>
                    
                    <div class="flex justify-between text-[13px] text-gray-600 mb-3">
                        <span>Biaya sewa (Rp {{ number_format($rental->item->price ?? 0, 0, ',', '.') }} × {{ $days }} hari)</span>
                        <span class="font-semibold text-gray-900">{{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                    
                    @if($deposit > 0)
                    <div class="flex justify-between text-[13px] text-gray-600 mb-6">
                        <span>Uang deposit (jaminan)</span>
                        <span class="font-semibold text-gray-900">{{ number_format($deposit, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    
                    <hr class="border-[#E5E7EB] mb-4">
                    
                    <div class="flex justify-between font-bold text-[18px] mb-6 text-gray-900">
                        <span>Total Transaksi:</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <h4 class="font-semibold text-[14px] mb-3 text-gray-900">Metode Pembayaran</h4>
                    
                    <div class="space-y-3 mb-6">
                        <label class="block border-[2px] border-[#34699A] rounded-[8px] p-[16px] cursor-pointer relative transition bg-white" id="label-penuh" onclick="selectPayment('penuh')">
                            <input type="radio" name="payment_method" value="penuh" class="hidden" checked>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-[#34699A]" id="icon-penuh" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <div>
                                        <div class="font-bold text-[14px] text-gray-900">Bayar Penuh</div>
                                        <div class="text-[12px] text-gray-500">Selesaikan seluruh pembayaran sekarang</div>
                                    </div>
                                </div>
                                <div class="w-5 h-5 rounded-full bg-[#34699A] flex items-center justify-center text-white text-[10px]" id="check-penuh">✓</div>
                            </div>
                        </label>

                        <label class="block border border-[#E5E7EB] rounded-[8px] p-[16px] cursor-pointer relative transition bg-white" id="label-paylater" onclick="selectPayment('paylater')">
                            <input type="radio" name="payment_method" value="paylater" class="hidden">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-gray-400" id="icon-paylater" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <div>
                                        <div class="font-bold text-[14px] text-gray-900">Cicilan (Paylater)</div>
                                        <div class="text-[12px] text-gray-500">Siklus pembayaran per 14 hari</div>
                                    </div>
                                </div>
                                <div class="w-5 h-5 rounded-full border border-gray-300 hidden items-center justify-center text-white text-[10px]" id="check-paylater">✓</div>
                            </div>

                            <div id="tenor-options" class="mt-4 pt-4 border-t border-gray-200 hidden">
                                <p class="text-[12px] font-semibold mb-2 text-gray-700">Pilih Tenor</p>
                                <div class="space-y-2">
                                    <div id="tenor-2x" onclick="selectTenor(2, event)" class="flex items-center justify-between border-[2px] border-[#34699A] rounded-[6px] p-3 bg-white cursor-pointer transition hover:bg-gray-50">
                                        <div>
                                            <div class="text-[13px] font-bold text-gray-900">Cicilan 2x</div>
                                            <div class="text-[11px] text-gray-500">Siklus 14 hari</div>
                                        </div>
                                        <div id="text-2x" class="text-[13px] font-bold text-[#34699A]">Rp {{ number_format($total / 2, 0, ',', '.') }}</div>
                                    </div>
                                    <div id="tenor-4x" onclick="selectTenor(4, event)" class="flex items-center justify-between border border-[#E5E7EB] rounded-[6px] p-3 bg-white cursor-pointer transition opacity-60 hover:opacity-100 hover:bg-gray-50">
                                        <div>
                                            <div class="text-[13px] font-bold text-gray-900">Cicilan 4x</div>
                                            <div class="text-[11px] text-gray-500">Siklus 14 hari</div>
                                        </div>
                                        <div id="text-4x" class="text-[13px] font-bold text-gray-900">Rp {{ number_format($total / 4, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-3 p-3 bg-[#F8FAFC] rounded-[6px]">
                                    <span class="text-[12px] font-medium text-gray-600">Pembayaran Pertama (Di Muka)</span>
                                    <span id="first-payment" class="text-[13px] font-bold text-gray-900">Rp {{ number_format($total / 2, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-[8px] p-[16px] mb-6 text-center text-[12px] text-gray-600 leading-relaxed">
                        Sistem pembayaran diamankan oleh <strong class="text-gray-800">Midtrans</strong>. Kode QR dan instruksi pembayaran akan muncul pada popup selanjutnya.
                    </div>

                    @if($payment->payment_status != 'paid')
                        <button id="pay-button" class="w-full bg-[#34699A] hover:bg-[#28537A] text-white text-[14px] font-bold py-[14px] rounded-[8px] transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            Konfirmasi Pembayaran
                        </button>
                    @endif

                    @if(isset($payment) && $payment->payment_status == 'expired')
                        <div class="mt-4 p-3 bg-[#FFECEF] text-[#E3455D] rounded-[8px] text-[13px] text-center border border-[#F4B8C2]">
                            Sesi telah kedaluwarsa. Silakan ulangi checkout.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </main>

    @include('layouts.partials.footer')

    <script>
        // Total pembayaran dari backend
        const totalAmount = {{ $total }};

        // Format angka ke format Rupiah
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        // Logika Interaktif Opsi Tenor Paylater
        function selectTenor(months, event) {
            // Mencegah selectPayment terpanggil saat mengklik tenor
            event.stopPropagation();
            
            const tenor2x = document.getElementById('tenor-2x');
            const tenor4x = document.getElementById('tenor-4x');
            const text2x = document.getElementById('text-2x');
            const text4x = document.getElementById('text-4x');
            const firstPayment = document.getElementById('first-payment');

            if (months === 2) {
                tenor2x.className = 'flex items-center justify-between border-[2px] border-[#34699A] rounded-[6px] p-3 bg-white cursor-pointer transition hover:bg-gray-50';
                text2x.className = 'text-[13px] font-bold text-[#34699A]';
                
                tenor4x.className = 'flex items-center justify-between border border-[#E5E7EB] rounded-[6px] p-3 bg-white cursor-pointer transition opacity-60 hover:opacity-100 hover:bg-gray-50';
                text4x.className = 'text-[13px] font-bold text-gray-900';

                firstPayment.innerText = 'Rp ' + formatRupiah(Math.floor(totalAmount / 2));
            } else if (months === 4) {
                tenor4x.className = 'flex items-center justify-between border-[2px] border-[#34699A] rounded-[6px] p-3 bg-white cursor-pointer transition hover:bg-gray-50';
                text4x.className = 'text-[13px] font-bold text-[#34699A]';
                
                tenor2x.className = 'flex items-center justify-between border border-[#E5E7EB] rounded-[6px] p-3 bg-white cursor-pointer transition opacity-60 hover:opacity-100 hover:bg-gray-50';
                text2x.className = 'text-[13px] font-bold text-gray-900';

                firstPayment.innerText = 'Rp ' + formatRupiah(Math.floor(totalAmount / 4));
            }
        }

        // Logika UI Pilihan Pembayaran Utama
        function selectPayment(method) {
            const labelPenuh = document.getElementById('label-penuh');
            const checkPenuh = document.getElementById('check-penuh');
            const iconPenuh = document.getElementById('icon-penuh');
            
            const labelPaylater = document.getElementById('label-paylater');
            const checkPaylater = document.getElementById('check-paylater');
            const iconPaylater = document.getElementById('icon-paylater');
            const tenorOptions = document.getElementById('tenor-options');

            if (method === 'penuh') {
                labelPenuh.className = 'block border-[2px] border-[#34699A] rounded-[8px] p-[16px] cursor-pointer relative transition bg-white';
                checkPenuh.className = 'w-5 h-5 rounded-full bg-[#34699A] flex items-center justify-center text-white text-[10px]';
                iconPenuh.classList.add('text-[#34699A]');
                iconPenuh.classList.remove('text-gray-400');
                
                labelPaylater.className = 'block border border-[#E5E7EB] rounded-[8px] p-[16px] cursor-pointer relative transition bg-white';
                checkPaylater.className = 'w-5 h-5 rounded-full border border-gray-300 hidden items-center justify-center text-white text-[10px]';
                iconPaylater.classList.remove('text-[#34699A]');
                iconPaylater.classList.add('text-gray-400');
                
                tenorOptions.classList.add('hidden');
            } else {
                labelPenuh.className = 'block border border-[#E5E7EB] rounded-[8px] p-[16px] cursor-pointer relative transition bg-white';
                checkPenuh.className = 'w-5 h-5 rounded-full border border-gray-300 hidden items-center justify-center text-white text-[10px]';
                iconPenuh.classList.remove('text-[#34699A]');
                iconPenuh.classList.add('text-gray-400');
                
                labelPaylater.className = 'block border-[2px] border-[#34699A] rounded-[8px] p-[16px] cursor-pointer relative transition bg-[#F8FAFC]';
                checkPaylater.className = 'w-5 h-5 rounded-full bg-[#34699A] flex items-center justify-center text-white text-[10px]';
                iconPaylater.classList.remove('text-gray-400');
                iconPaylater.classList.add('text-[#34699A]');
                
                tenorOptions.classList.remove('hidden');
            }
        }

        // Logika Midtrans Snap
        const payButton = document.getElementById('pay-button');
        const tncCheckbox = document.getElementById('tnc-checkbox');

        if (payButton) {
            payButton.addEventListener('click', function() {
                
                if (!tncCheckbox.checked) {
                    alert('Silakan centang persetujuan Aturan dan Kebijakan Sewa terlebih dahulu.');
                    return;
                }

                payButton.disabled = true;
                payButton.innerHTML = 'Memproses...';

                if (!'{{ $snapToken }}') {
                    alert('Snap Token tidak tersedia.');
                    payButton.disabled = false;
                    payButton.innerHTML = 'Konfirmasi Pembayaran';
                    return;
                }

                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        payButton.innerHTML = 'Berhasil';
                        setTimeout(function() {
                            window.location.href = "{{ route('riwayat.transaksi.penyewa') }}";
                        }, 1500);
                    },
                    onPending: function(result) {
                        alert('Pembayaran masih menunggu penyelesaian.');
                        payButton.disabled = false;
                        payButton.innerHTML = 'Konfirmasi Pembayaran';
                    },
                    onError: function(result) {
                        alert('Terjadi kesalahan pembayaran.');
                        payButton.disabled = false;
                        payButton.innerHTML = 'Konfirmasi Pembayaran';
                    },
                    onClose: function() {
                        payButton.disabled = false;
                        payButton.innerHTML = 'Konfirmasi Pembayaran';
                    }
                });
            });
        }
    </script>
</body>
</html>