<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class AdminController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            'auth',
            'role:admin'
        ];
    }

    public function adminDashboard ()
    {
        return view('admin.index');
    }
}
