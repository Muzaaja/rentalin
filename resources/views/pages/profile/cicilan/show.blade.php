@extends('layouts.app')

@section('content')
<div class="profile-page">
    <div class="container profile-layout">
        
        {{-- ================= SIDEBAR ================= --}}
        <aside class="profile-sidebar">
            <div class="sidebar-profile">
                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('assets/img/profile/user-photo-profile.png') }}" class="avatar-lg" alt="Avatar">
                <h3>{{ trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: $user->name }}</h3>
                <small>{{ $user->email }}</small>
            </div>
            <div class="sidebar-menu">
                <a href="{{ route('profile.edit') }}" class="menu-btn">👤 Profil</a>
                <a href="{{ route('riwayat.transaksi.penyewa') }}" class="menu-btn">📜 Riwayat</a>
                <a href="{{ route('profile.edit') }}" class="menu-btn">⚙ Pengaturan</a>
                <a href="{{ route('profile.cicilan.index') }}" class="menu-btn active">💳 Cicilan</a>
            </div>
        </aside>

        {{-- ================= KONTEN DETAIL ================= --}}
        <section class="profile-content">
            
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                <a href="{{ route('profile.cicilan.index') }}" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border: 1px solid #d1d5db; border-radius: 50%; text-decoration: none; color: #374151; background: white;">❮</a>
                <h2 style="font-size: 24px; font-weight: bold; margin: 0; color: #1f2937;">Detail Cicilan Pembayaran</h2>
            </div>

            @php
                $item = $payment->rental->item;
                $img = is_array($item->image) && count($item->image) > 0 ? $item->image[0] : $item->image;
                $url = $img ? asset('storage/'.$img) : asset('assets/products/default-product.png');
                
                $totalPaid = $payment->installments->where('status', 'paid')->sum('amount');
                $progressPercent = ($payment->installments->where('status', 'paid')->count() / $payment->installment_plan) * 100;
            @endphp

            {{-- Info Barang --}}
            <div class="profile-card">
                <div style="display: flex; gap: 20px;">
                    <img src="{{ $url }}" style="width: 120px; height: 90px; border-radius: 8px; object-fit: cover;">
                    <div style="flex: 1;">
                        <span style="background-color: #FFF0C2; color: #D38A00; font-size: 11px; font-weight: bold; padding: 4px 10px; border-radius: 99px; margin-bottom: 8px; display: inline-block;">
                            {{ $payment->payment_status == 'paid' ? 'Lunas' : 'Sedang Berjalan' }}
                        </span>
                        <h3 style="font-size: 18px; font-weight: bold; margin: 0 0 4px 0;">{{ $item->name }}</h3>
                        <p style="font-size: 13px; color: #6b7280; margin: 0 0 16px 0;">Disewa dari: <span style="color: #34699A; font-weight: 500;">{{ $payment->rental->owner->name }}</span></p>
                        
                        <div style="display: flex; justify-content: space-between; border-top: 1px solid #e5e7eb; padding-top: 16px;">
                            <div>
                                <p style="font-size: 12px; color: #6b7280; margin: 0 0 4px 0;">Total Nilai Transaksi</p>
                                <p style="font-size: 15px; font-weight: bold; margin: 0;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </div>
                            <div style="text-align: right;">
                                <p style="font-size: 12px; color: #6b7280; margin: 0 0 4px 0;">Tenor</p>
                                <p style="font-size: 15px; font-weight: bold; margin: 0;">{{ $payment->installment_plan }}x Pembayaran</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progres --}}
            <div class="profile-card">
                <h3 style="font-size: 16px; font-weight: bold; margin: 0 0 16px 0;">Progres Pembayaran</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
                    <div>
                        <p style="font-size: 12px; color: #6b7280; margin: 0 0 4px 0;">Total Terbayar</p>
                        <p style="font-size: 20px; font-weight: bold; color: #34699A; margin: 0;">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-size: 12px; color: #6b7280; margin: 0 0 4px 0;">Sisa Tagihan</p>
                        <p style="font-size: 20px; font-weight: bold; color: #111827; margin: 0;">Rp {{ number_format($payment->amount - $totalPaid, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                <p style="font-size: 12px; font-weight: 500; color: #4b5563; margin: 0 0 8px 0;">{{ round($progressPercent) }}% Selesai ({{ $payment->installments->where('status', 'paid')->count() }} dari {{ $payment->installment_plan }} Cicilan)</p>
                <div style="width: 100%; height: 8px; background-color: #e5e7eb; border-radius: 99px; overflow: hidden;">
                    <div style="height: 100%; background-color: #005B82; width: {{ $progressPercent }}%;"></div>
                </div>
            </div>

            <h3 style="font-size: 18px; font-weight: bold; margin: 0 0 16px 0;">Jadwal & Riwayat</h3>

            <div style="display: flex; flex-direction: column; gap: 16px;">
                @foreach($payment->installments as $inst)
                    @if($inst->status == 'paid')
                        {{-- Lunas --}}
                        <div class="profile-card" style="margin: 0; display: flex; justify-content: space-between; align-items: center; padding: 20px;">
                            <div>
                                <h4 style="font-size: 16px; font-weight: bold; margin: 0 0 4px 0;">Cicilan {{ $inst->term_number }}</h4>
                                <p style="font-size: 13px; color: #6b7280; margin: 0 0 8px 0;">Jatuh Tempo: {{ $inst->due_date->format('d M Y') }}</p>
                                <p style="font-size: 16px; font-weight: bold; margin: 0;">Rp {{ number_format($inst->amount, 0, ',', '.') }}</p>
                            </div>
                            <div style="text-align: right;">
                                <span style="background-color: #34699A; color: white; font-size: 12px; font-weight: bold; padding: 6px 12px; border-radius: 6px; display: inline-block; margin-bottom: 8px;">✔ Lunas</span>
                                <p style="font-size: 11px; color: #6b7280; margin: 0;">Dibayar pada: {{ $inst->paid_at ? $inst->paid_at->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                    @elseif($inst->status == 'overdue' || ($inst->status == 'pending' && $loop->iteration == $payment->installments->where('status', 'paid')->count() + 1))
                        {{-- Tagihan Aktif --}}
                        <div class="profile-card" style="margin: 0; border: 2px solid #34699A; position: relative; overflow: hidden; display: flex; justify-content: space-between; align-items: center; padding: 20px;">
                            <div style="position: absolute; top: 0; left: 0; background-color: #34699A; color: white; font-size: 10px; font-weight: bold; padding: 4px 12px; border-bottom-right-radius: 8px;">Tagihan Aktif</div>
                            <div style="margin-top: 12px;">
                                <h4 style="font-size: 16px; font-weight: bold; margin: 0 0 4px 0;">Cicilan {{ $inst->term_number }}</h4>
                                <p style="font-size: 13px; color: #6b7280; margin: 0 0 8px 0;">Jatuh Tempo: {{ $inst->due_date->format('d M Y') }}</p>
                                <p style="font-size: 18px; font-weight: bold; margin: 0;">Rp {{ number_format($inst->amount, 0, ',', '.') }}</p>
                            </div>
                            <div style="text-align: right;">
                                <span style="background-color: #FFECEF; color: #E3455D; border: 1px solid #F4B8C2; font-size: 12px; font-weight: bold; padding: 6px 12px; border-radius: 6px; display: inline-block; margin-bottom: 12px;">Belum Bayar</span>
                                <br>
                                {{-- PERUBAHAN DI SINI: Mengubah button menjadi link a href --}}
                                <a href="{{ route('checkout.installment', $inst->id) }}" style="background-color: #34699A; color: white; border: none; font-size: 13px; font-weight: bold; padding: 10px 20px; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; transition: 0.2s;">Bayar Sekarang</a>
                            </div>
                        </div>
                    @else
                        {{-- Menunggu --}}
                        <div class="profile-card" style="margin: 0; background-color: #f9fafb; opacity: 0.7; display: flex; justify-content: space-between; align-items: center; padding: 20px;">
                            <div>
                                <h4 style="font-size: 16px; font-weight: bold; color: #6b7280; margin: 0 0 4px 0;">Cicilan {{ $inst->term_number }}</h4>
                                <p style="font-size: 13px; color: #9ca3af; margin: 0 0 8px 0;">Jatuh Tempo: {{ $inst->due_date->format('d M Y') }}</p>
                                <p style="font-size: 16px; font-weight: bold; color: #6b7280; margin: 0;">Rp {{ number_format($inst->amount, 0, ',', '.') }}</p>
                            </div>
                            <span style="background-color: #e5e7eb; color: #4b5563; font-size: 12px; font-weight: bold; padding: 6px 12px; border-radius: 6px;">Menunggu</span>
                        </div>
                    @endif
                @endforeach
            </div>

        </section>
    </div>
</div>
@endsection