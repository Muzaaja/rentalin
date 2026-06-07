<div id="detail-panel" class="absolute inset-y-0 right-0 w-[400px] bg-white border-l border-gray-200 shadow-2xl z-40 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col h-full overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50">
        <div>
            <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                Detail Review <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-0.5 rounded uppercase font-bold tracking-wider">Pending</span>
            </h3>
            <p id="panel-date" class="text-[11px] text-gray-500 mt-1">-</p>
        </div>
        <button onclick="closeDetailPanel()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto p-5 space-y-6 bg-gray-50/30">
        
        <div>
            <h4 class="text-[11px] font-bold text-gray-800 mb-3 border-b border-gray-200 pb-1">Detail Toko</h4>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase mb-1">Nama Toko</p>
                    <p id="panel-nama-toko" class="text-xs font-bold text-gray-900">-</p>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase mb-1">Pemilik</p>
                    <p id="panel-pemilik" class="text-xs font-semibold text-gray-800">-</p>
                </div>
            </div>
            <div>
                <p class="text-[10px] font-semibold text-gray-400 uppercase mb-1">Alamat</p>
                <p id="panel-alamat" class="text-xs text-gray-700 leading-relaxed">-</p>
            </div>
        </div>

        <div>
            <h4 class="text-[11px] font-bold text-gray-800 mb-3 border-b border-gray-200 pb-1">Dokumen</h4>
            
            <div class="space-y-4">
                <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                    <p class="text-[11px] font-semibold text-gray-700 mb-2">KTP Pemilik</p>
                    <div class="aspect-[3/2] w-full bg-gray-100 rounded-lg overflow-hidden relative group">
                        <img id="img-ktp" src="" class="w-full h-full object-cover" alt="Foto KTP">
                    </div>
                </div>

                <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                    <p class="text-[11px] font-semibold text-gray-700 mb-2">Selfie Pemilik</p>
                    <div class="aspect-[3/2] w-full bg-gray-100 rounded-lg overflow-hidden relative group">
                        <img id="img-selfie" src="" class="w-full h-full object-cover" alt="Foto Selfie">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-5 border-t border-gray-100 bg-white space-y-3">
        <button type="button" onclick="openModalTerima()" class="w-full bg-[#34699A] hover:bg-[#28537a] text-white font-semibold py-2.5 rounded-xl text-sm transition shadow-sm">
            Terima
        </button>
        <button type="button" onclick="openModalTolak()" class="w-full bg-white hover:bg-red-50 text-red-600 font-semibold py-2.5 rounded-xl border border-red-200 text-sm transition">
            Tolak
        </button>
    </div>
</div>