@extends('pages.admin.layout')

@section('title', 'Verifikasi KYC Toko')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Verifikasi Toko</h1>
    <p class="text-sm text-gray-500">Manajemen verifikasi toko</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="text-sm font-bold text-gray-800">Antrian Verifikasi</h3>
        <button class="text-[#34699A] text-xs font-semibold flex items-center gap-1 hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Filter
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm border-collapse">
            <thead>
                <tr class="text-gray-500 text-[11px] font-bold uppercase tracking-wider border-b border-gray-100">
                    <th class="p-4 w-24 text-center">Toko ID</th>
                    <th class="p-4">Nama Toko</th>
                    <th class="p-4">Nama Owner</th>
                    <th class="p-4">Tanggal Dikirim</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($pendingToko as $toko)
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="p-4 text-center text-xs text-gray-500">TOK-<br>{{ $toko->id }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($toko->nama_toko) }}&background=EBF4FF&color=34699A" class="w-8 h-8 rounded-full object-cover">
                                <p class="font-bold text-gray-900 text-xs">{{ $toko->nama_toko }}</p>
                            </div>
                        </td>
                        <td class="p-4 text-xs font-semibold text-gray-600">{{ $toko->user->name ?? $toko->nama_lengkap_ktp }}</td>
                        <td class="p-4 text-xs text-gray-600">
                            {{ $toko->created_at->translatedFormat('d M, Y') }}<br>
                            <span class="text-[10px] text-gray-400">{{ $toko->created_at->format('H:i A') }}</span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2.5 py-1 rounded-full font-bold uppercase tracking-wide">Pending</span>
                        </td>
                        <td class="p-4 text-center">
                            <button type="button" 
                                    onclick="openDetailPanel('{{ $toko->id }}', '{{ $toko->nama_toko }}', '{{ $toko->user->name ?? $toko->nama_lengkap_ktp }}', '{{ $toko->alamat_toko }}', '{{ $toko->created_at->translatedFormat('d M Y \j\a\m H:i A') }}', '{{ asset('storage/'.$toko->foto_ktp) }}', '{{ asset('storage/'.$toko->foto_selfie) }}')"
                                    class="bg-[#34699A] hover:bg-[#28537a] text-white text-[11px] font-semibold px-4 py-1.5 rounded-lg transition shadow-sm">
                                Review
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 text-sm">Tidak ada antrean pengajuan KYC Toko.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100 bg-gray-50/50 flex justify-between items-center text-[11px] text-gray-500">
        <span>Menampilkan {{ count($pendingToko) }} Item</span>
    </div>
</div>
@endsection

@section('panel')
    @include('pages.admin.kyc_toko._detail_panel')
@endsection

@section('modals')
    @include('pages.admin.partials._modal_terima')
    @include('pages.admin.partials._modal_tolak')
@endsection

@push('scripts')
<script>
    let currentTokoId = null;

    function openDetailPanel(id, namaToko, pemilik, alamat, date, ktpUrl, selfieUrl) {
        currentTokoId = id;
        document.getElementById('panel-nama-toko').textContent = namaToko;
        document.getElementById('panel-pemilik').textContent = pemilik;
        document.getElementById('panel-alamat').textContent = alamat;
        document.getElementById('panel-date').textContent = 'Dikirim: ' + date;
        document.getElementById('img-ktp').src = ktpUrl;
        document.getElementById('img-selfie').src = selfieUrl;
        
        // Atur URL form action untuk modal
        document.getElementById('form-approve').action = `/admin/kyc-toko/${id}/approve`;
        document.getElementById('form-reject').action = `/admin/kyc-toko/${id}/reject`;

        document.getElementById('detail-panel').classList.remove('translate-x-full');
    }

    function closeDetailPanel() {
        document.getElementById('detail-panel').classList.add('translate-x-full');
    }

    function openModalTerima() {
        const modal = document.getElementById('modal-terima');
        modal.classList.remove('invisible');
        modal.querySelector('.bg-white').classList.remove('scale-95', 'opacity-0');
    }

    function closeModalTerima() {
        const modal = document.getElementById('modal-terima');
        modal.querySelector('.bg-white').classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('invisible'), 200);
    }

    function openModalTolak() {
        const modal = document.getElementById('modal-tolak');
        modal.classList.remove('invisible');
        modal.querySelector('.bg-white').classList.remove('scale-95', 'opacity-0');
    }

    function closeModalTolak() {
        const modal = document.getElementById('modal-tolak');
        modal.querySelector('.bg-white').classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('invisible'), 200);
    }
</script>
@endpush