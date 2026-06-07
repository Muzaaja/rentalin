<div id="modal-terima" class="fixed inset-0 z-50 invisible flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeModalTerima()"></div>
    <div class="bg-white rounded-3xl p-6 max-w-sm w-full relative z-10 shadow-2xl text-center transform scale-95 opacity-0 transition-all duration-200">
        <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-emerald-100">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-1">Setujui Verifikasi?</h3>
        <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menyetujui verifikasi? Tindakan ini tidak dapat dibatalkan.</p>
        
        <form id="form-approve" action="#" method="POST" class="flex gap-3">
            @csrf
            @method('PATCH')
            <button type="button" onclick="closeModalTerima()" class="flex-1 py-3 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Batal</button>
            <button type="submit" class="flex-1 py-3 bg-[#34699A] hover:bg-[#28537a] text-white rounded-xl text-sm font-semibold transition shadow-sm">Ya, Setuju</button>
        </form>
    </div>
</div>