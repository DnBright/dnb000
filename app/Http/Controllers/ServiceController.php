<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show($paket)
    {
        // Fetch package from database by name (slugified)
        $package = \App\Models\DesignPackage::where('status', 'active')
            ->where('name', 'LIKE', str_replace('-', ' ', $paket))
            ->first();

        if (!$package) {
            // Fallback for slugs that might not match exactly or for generic names
            $package = \App\Models\DesignPackage::where('status', 'active')
                ->where('category', 'LIKE', $paket)
                ->first();
        }

        $info = $package ? [
            'title' => $package->name,
            'description' => $package->description
        ] : [
            'title' => ucwords(str_replace('-', ' ', $paket)),
            'description' => ''
        ];

        return view('layanan.show', ['paket' => $paket, 'info' => $info, 'package' => $package]);
    }
}
