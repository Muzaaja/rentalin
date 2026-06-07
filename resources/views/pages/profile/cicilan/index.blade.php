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
                {{-- Menu Cicilan Aktif --}}
                <a href="{{ route('profile.cicilan.index') }}" class="menu-btn active">💳 Cicilan</a>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="menu-btn logout-btn">🚪 Keluar</button>
                </form>
            </div>
        </aside>

        {{-- ================= CONTENT ================= --}}
        <section class="profile-content">
            
            <div style="margin-bottom: 24px;">
                <h2 style="font-size: 24px; font-weight: bold; color: #1f2937;">Tagihan Cicilan Saya</h2>
            </div>

            {{-- Ringkasan --}}
            <div class="profile-card" style="background-color: #E6F0F9; border-color: #C3DAFE; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; padding: 24px;">
                <div>
                    <p style="color: #34699A; font-size: 14px; font-weight: 600; margin-bottom: 4px;">Total Tagihan Bulan Ini</p>
                    <p style="font-size: 28px; font-weight: bold; color: #111827; margin: 0;">Rp {{ number_format($summary['total_tagihan'], 0, ',', '.') }}</p>
                </div>
                <div style="text-align: right;">
                    <p style="color: #34699A; font-size: 14px; font-weight: 600; margin-bottom: 4px;">Jatuh Tempo Terdekat</p>
                    <p style="font-size: 16px; font-weight: bold; color: #111827; margin: 0;">{{ $summary['jatuh_tempo_terdekat'] }}</p>
                </div>
            </div>

            {{-- Tabs --}}
            <div style="display: flex; border-bottom: 1px solid #e5e7eb; margin-bottom: 24px; gap: 20px;">
                <a href="?tab=belum_lunas" style="padding-bottom: 12px; font-weight: 600; text-decoration: none; border-bottom: 3px solid {{ $tab == 'belum_lunas' ? '#34699A' : 'transparent' }}; color: {{ $tab == 'belum_lunas' ? '#34699A' : '#6b7280' }};">Belum Lunas</a>
                <a href="?tab=selesai" style="padding-bottom: 12px; font-weight: 600; text-decoration: none; border-bottom: 3px solid {{ $tab == 'selesai' ? '#34699A' : 'transparent' }}; color: {{ $tab == 'selesai' ? '#34699A' : '#6b7280' }};">Cicilan Selesai</a>
            </div>

            {{-- Grid Cards --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                @forelse($payments as $payment)
                    {{-- Cek apakah rental ada --}}
                    @if(!$payment->rental) @continue @endif

                    @php
                        $item = $payment->rental->item;
                        $owner = $payment->rental->owner;
                        $img = is_array($item->image) && count($item->image) > 0 ? $item->image[0] : $item->image;
                        $url = $img ? asset('storage/'.$img) : asset('assets/products/default-product.png');
                        
                        // Cari cicilan yang masih aktif
                        $activeInstallment = $payment->installments->whereIn('status', ['pending', 'overdue'])->first();
                    @endphp

                    {{-- FIX: Jika tab 'belum_lunas' tapi TIDAK ada cicilan aktif, JANGAN tampilkan --}}
                    @if($tab == 'belum_lunas' && !$activeInstallment) 
                        @continue 
                    @endif

                    {{-- FIX: Jika tab 'selesai' tapi MASIH ada cicilan aktif, JANGAN tampilkan --}}
                    @if($tab == 'selesai' && $activeInstallment) 
                        @continue 
                    @endif

                    <div class="profile-card" style="margin: 0; padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <div style="font-size: 13px; font-weight: 600; color: #4b5563;">🏢 {{ $owner->name }}</div>
                            
                            @if($tab == 'belum_lunas' && $activeInstallment)
                                @if($activeInstallment->status == 'overdue')
                                    <span style="background-color: #FFECEF; color: #E3455D; font-size: 11px; font-weight: bold; padding: 4px 10px; border-radius: 99px;">Terlambat</span>
                                @else
                                    <span style="background-color: #FFF0C2; color: #D38A00; font-size: 11px; font-weight: bold; padding: 4px 10px; border-radius: 99px;">Jatuh tempo: {{ $activeInstallment->due_date->format('d M') }}</span>
                                @endif
                            @else
                                <span style="background-color: #E6F4EA; color: #118642; font-size: 11px; font-weight: bold; padding: 4px 10px; border-radius: 99px;">Lunas</span>
                            @endif
                        </div>

                        <div style="display: flex; gap: 16px; margin-bottom: 20px;">
                            <img src="{{ $url }}" style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover;">
                            <div>
                                <h3 style="font-weight: bold; font-size: 16px; margin: 0 0 4px 0;">{{ $item->name }}</h3>
                                @if($tab == 'belum_lunas' && $activeInstallment)
                                    <p style="font-size: 13px; color: #6b7280; margin: 0 0 4px 0;">Pembayaran {{ $activeInstallment->term_number }} dari {{ $payment->installment_plan }}</p>
                                    <p style="font-size: 13px; font-weight: 500; color: {{ $activeInstallment->status == 'overdue' ? '#E3455D' : '#6b7280' }}; margin: 0;">Jatuh tempo: {{ $activeInstallment->due_date->format('d M Y') }}</p>
                                @else
                                    <p style="font-size: 13px; color: #6b7280; margin: 0 0 4px 0;">Pembayaran Lunas</p>
                                @endif
                            </div>
                        </div>

                        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin-bottom: 16px;">

                        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                            <div>
                                <p style="font-size: 12px; color: #6b7280; margin: 0 0 4px 0;">{{ $tab == 'belum_lunas' ? 'Nominal Tagihan' : 'Total Dibayar' }}</p>
                                <p style="font-size: 18px; font-weight: bold; margin: 0;">Rp {{ number_format($tab == 'belum_lunas' && $activeInstallment ? $activeInstallment->amount : $payment->amount, 0, ',', '.') }}</p>
                            </div>
                            @if($tab == 'belum_lunas')
                                <a href="{{ route('profile.cicilan.show', $payment->id) }}" style="background-color: #34699A; color: white; text-decoration: none; font-size: 13px; font-weight: bold; padding: 10px 16px; border-radius: 6px;">Bayar Sekarang</a>
                            @else
                                <a href="{{ route('profile.cicilan.show', $payment->id) }}" style="border: 1px solid #34699A; color: #34699A; text-decoration: none; font-size: 13px; font-weight: bold; padding: 10px 16px; border-radius: 6px;">Lihat Detail</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; padding: 40px; text-align: center; background: white; border: 1px solid #e5e7eb; border-radius: 10px;">
                        <p style="color: #6b7280; margin: 0;">Tidak ada data tagihan cicilan.</p>
                    </div>
                @endforelse
            </div>

        </section>

    </div>
</div>

@endsection