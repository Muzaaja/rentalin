<div id="modal-tolak" class="fixed inset-0 z-50 invisible flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeModalTolak()"></div>
    <div class="bg-white rounded-3xl p-6 max-w-sm w-full relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-200">
        <h3 class="text-lg font-bold text-[#F43F5E] text-center mb-1 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            Tolak Verifikasi?
        </h3>
        <p class="text-sm text-gray-500 text-center mb-4 mt-2">Silakan berikan alasan penolakan agar pengguna dapat memperbaiki data mereka.</p>
        
        <form id="form-reject" action="#" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Alasan Penolakan</label>
                <textarea name="reason" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#34699A] focus:border-[#34699A] outline-none text-sm bg-gray-50 resize-none transition" placeholder="Contoh: Foto KTP tidak jelas, Data tidak sesuai" required></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModalTolak()" class="flex-1 py-3 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-[#F43F5E] hover:bg-rose-600 text-white rounded-xl text-sm font-semibold transition shadow-sm">Ya, Tolak</button>
            </div>
        </form>
    </div>
</div>