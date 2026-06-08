<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('pages.profile.edit', [
            'user' => $request->user()->load('kyc'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // 1. Ambil data yang sudah divalidasi dari ProfileUpdateRequest
        $data = $request->validated();

        // 2. Tangani unggahan file avatar
        if ($request->hasFile('avatar')) {
            $user = $request->user();

            // Hapus file avatar lama jika ada untuk menghemat ruang
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan file avatar baru dan dapatkan path public-nya
            $path = $request->file('avatar')->store('avatars', 'public');
            
            // Simpan path public di dalam array data
            $data['avatar'] = $path;
        }

        // 3. Perbarui data user di database
        $request->user()->update($data);

        // 4. Kembalikan ke halaman edit dengan pesan sukses
        return redirect()
            ->route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}