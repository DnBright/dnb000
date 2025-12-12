<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminMemberController extends Controller
{
    public function index()
    {
        // Page removed — return 410 Gone to indicate resource was removed
        abort(410, 'Members page removed');
    }
}
