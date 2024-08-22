<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class InstructorController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            'role:instructor'
        ];
    }

    public function instructorDashboard()
    {
        return view('instructor.instructor_dashboard');
    }
}
