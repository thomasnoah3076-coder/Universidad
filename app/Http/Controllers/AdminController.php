<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard(): View
    {
        return view('dashboard');
    }

    /**
     * Show the application settings.
     */
    public function settings(): View
    {
        return view('settings');
    }
}
