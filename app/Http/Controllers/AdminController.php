<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('auth', except:['login', 'auth']),
            new Middleware('role:admin', except:['login', 'auth'])
        ];
    }

    public function adminDashboard ()
    {
        return view('admin.index');
    }

    public function login ()
    {
        return view('admin.admin_login');
    }

    public function auth(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    public function profile ()
    {
        $user = Auth::user();
        $profileImgUrl = $user->photo ? url("upload/admin_images/$user->photo"):asset('upload/no_image.jpg');
        return view('admin.admin_profile', [
            'user' => $user,
            'profileImgUrl' => $profileImgUrl
        ]);
    }

    public function profileStore (Request $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $user->photo = $filename;
        }

        $user->save();

        return redirect()
            ->back()
            ->with('message', 'Profile info was updated successfully!');
    }

    public function changePassword ()
    {
        $user = Auth::user();
        $profileImgUrl = $user->photo ? url("upload/admin_images/$user->photo"):asset('upload/no_image.jpg');
        return view('admin.admin_change_password', [
            'user' => $user,
            'profileImgUrl' => $profileImgUrl
        ]);
    }

    public function updatePassword (Request $request)
    {
        $user = User::findOrFail(Auth::User()->id);

        $passwords = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
        ]);
        if (!Hash::check($request->input('old_password'), $user->password)) {
            throw ValidationException::withMessages(['old_password' => 'Incorrect old password']);
        }

        $user->password = Hash::make($passwords['new_password']);
        $user->save();
        return redirect()
            ->route('admin.profile')
            ->with('message', 'The password has been successfully updated!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
