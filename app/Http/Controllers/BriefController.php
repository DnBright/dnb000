<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BriefController extends Controller
{
    public function review(Request $request)
    {
        $data = $request->all();

        // simpan session agar GET bisa ambil data
        session(['reviewData' => $data]);
        
        // simpan paket jika ada di request
        if ($request->has('paket')) {
            session(['selectedPaket' => $request->input('paket')]);
        }

        return redirect()->route('review.show');
    }

    public function show()
    {
        $data = session('reviewData');
        $paket = session('selectedPaket', 'standard');

        return view('review', compact('data', 'paket'));
    }
}
