<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;

class JadwalController extends Controller
{
    public function index()
    {
        $items = JadwalPeriksa::with(['dokter', 'poli'])->orderBy('hari')->paginate(20);
        return view('admin.jadwal.index', compact('items'));
    }
}

