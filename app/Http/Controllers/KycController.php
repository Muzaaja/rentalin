<?php

namespace App\Http\Controllers;

use App\Models\Kyc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KycController extends Controller
{
    public function step1()
    {
        return view('pages.kyc.step1');
    }

    public function simpanStep1(Request $request)
{
    $request->validate([
        'identity_photo' => 'required|image|max:10240',
    ]);

    $identityPhoto = $request->file('identity_photo')
        ->store('kyc', 'public');

    session([
        'kyc.identity_photo' => $identityPhoto,
    ]);

    return redirect()->route('kyc.step2');
    }

    public function step2()
    {
        return view('pages.kyc.step2');
    }

    public function simpanStep2(Request $request)
{
    $request->validate([
        'selfie_photo' => 'required|image|max:10240',
    ]);

    $selfiePhoto = $request->file('selfie_photo')
        ->store('kyc', 'public');

    Kyc::updateOrCreate(
        [
            'user_id' => auth()->id(),
        ],
        [
            'identity_photo' => session('kyc.identity_photo'),
            'selfie_photo' => $selfiePhoto,
            'status' => 'pending',
        ]
    );

    session()->forget('kyc');

    return redirect()
        ->route('profile.edit')
        ->with('success', 'Verifikasi berhasil dikirim');
    }
}