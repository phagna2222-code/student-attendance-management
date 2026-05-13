<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['nullable'],
        ]);

        $field = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $candidate = User::where($field, $data['email'])->first();
        if ($candidate && $candidate->locked_until && $candidate->locked_until->isFuture()) {
            throw ValidationException::withMessages([
                'email' => __('admin.account_locked_until', ['time' => $candidate->locked_until->format('H:i')]),
            ]);
        }

        if (! Auth::attempt([$field => $data['email'], 'password' => $data['password']], (bool) ($data['remember'] ?? false))) {
            if ($candidate) {
                $attempts = ($candidate->failed_login_attempts ?? 0) + 1;
                $updates = ['failed_login_attempts' => $attempts];
                if ($attempts >= 5) {
                    $updates['locked_until'] = now()->addMinutes(15);
                }
                $candidate->update($updates);
            }
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();
        $user = $request->user();
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ]);

        flash()->success(__('admin.dashboard') . ' — ' . __('Welcome back!'));

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
