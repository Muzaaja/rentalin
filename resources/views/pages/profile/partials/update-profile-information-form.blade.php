<section>
    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                Pengaturan Akun
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Kelola informasi pribadi akun Rentalin Anda
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <div class="mb-6">
            <x-input-label value="{{ __('Foto Profil') }}" />
            <div class="mt-2 flex items-center gap-6">
                <div class="relative w-24 h-24 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden bg-gray-50">
                    <img id="preview-avatar" 
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}" 
                         class="w-full h-full object-cover {{ $user->avatar ? '' : 'hidden' }}" 
                         alt="Preview Profil">

                    <div id="empty-state" class="text-gray-400 flex flex-col items-center justify-center w-full h-full {{ $user->avatar ? 'hidden' : 'flex' }}">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>

                <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50 transition shadow-sm">
                    Pilih Foto Baru
                    <input type="file" name="avatar" class="hidden" accept="image/jpeg, image/png, image/jpg" onchange="previewProfileImage(this)">
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" :value="old('name', $user->name)" required />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="phone" value="Nomor HP" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" :value="old('phone', $user->phone)" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="address" value="Alamat Lengkap" />
            <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $user->address) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="province" value="Provinsi" />
                <select id="province" name="province" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Pilih Provinsi</option>
                    <option value="Jawa Barat" {{ old('province', $user->province) == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                    </select>
                <x-input-error class="mt-2" :messages="$errors->get('province')" />
            </div>

            <div>
                <x-input-label for="city" value="Kota/Kabupaten" />
                <select id="city" name="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Pilih Kota/Kabupaten</option>
                    <option value="Bandung" {{ old('city', $user->city) == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                    </select>
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
        </div>

        <div>
            <x-input-label for="postal_code" value="Kode Pos" />
            <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm" :value="old('postal_code', $user->postal_code)" />
            <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                    {{ __('Disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>

<script>
    function previewProfileImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('preview-avatar');
                const emptyState = document.getElementById('empty-state');
                
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                
                if(emptyState) {
                    emptyState.classList.remove('flex');
                    emptyState.classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>