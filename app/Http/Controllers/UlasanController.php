<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UlasanController extends Controller
{
    // Halaman daftar ulasan
    public function index()
    {
        // BENAR: Mengarah ke store/dashboardStore/ulasanToko.blade.php
        return view('pages.store.dashboardStore.ulasanToko'); 
    }

}