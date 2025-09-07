<?php

namespace App\Http\Responses;

use App\Models\Enums\RoleEnum;
use App\Models\Enums\RoleStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        if (Auth::check()) {
            // Cek apakah permintaan menginginkan JSON
            if ($request->wantsJson()) {
                return response()->json(['two_factor' => false]);
            }
            $user = Auth::user();
            // Iterasi melalui semua case dalam enum RoleStatusEnum
            foreach (RoleEnum::cases() as $roleEnum) {
                if ($user->hasRole($roleEnum->value)) {
                    return redirect()->to('lims');
                }
            }
            // Jika pengguna tidak memiliki role yang sesuai
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda tidak memiliki akses yang valid.'
            ]);
        }

        // Jika pengguna tidak terautentikasi
        return redirect()->route('login');
    }
}
