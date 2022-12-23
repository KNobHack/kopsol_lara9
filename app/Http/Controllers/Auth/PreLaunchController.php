<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreLaunchRegisterRequest;
use App\Models\Central\User;
use App\Models\Central\UserDetail;
use Illuminate\Support\Facades\Hash;

class PreLaunchController extends Controller
{
    public function index()
    {
        return view('auth.prelaunch');
    }

    public function register(PreLaunchRegisterRequest $request)
    {
        $user = User::create([
            'role_id' => User::DefaultRoleId,
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
        ]);

        $user->detail()->create([
            'nama' => $request->validated('nama'),
            'jenis_kelamin' => $request->validated('jenis_kelamin'),
        ]);

        session()->flash('alert', [
            ['mode' => 'success', 'message' => 'Akun berhasil dibuat. Silahkan login'],
        ]);

        return redirect()->route('login');
    }

    public function welcome()
    {
        // 
    }

    public function comingSoon()
    {
        return 'Coming soon';
    }
}
