<?php

namespace App\Http\Controllers\PasswordDirectory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*форма для сброса пароля*/
    public function index($token,$email)
    {
        return view('ResetDirectory.reset', ['token' => $token, 'email' => $email]);
    }

    /*сброс пароля*/
    public function store(Request $request)
    {
        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {

                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );
            if ($status == Password::PASSWORD_RESET) {
                Log::debug('Password reset successful');
                $user = User::where('email', $request->get('email'))->first();
                Log::debug('Password reset start');
                $user->password = Hash::make($request->get('password'));
                Log::debug('Password reset continue');
                $user->save();
                Log::debug('Password reset save');
                return redirect('/')->with('status', __($status));
            } else {
                Log::debug('Password reset failed: ' . $status);
                return back()->withErrors(['email' => [__($status)]]);
            }
        } catch (\Exception $e) {
            Log::error('Password reset process failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
