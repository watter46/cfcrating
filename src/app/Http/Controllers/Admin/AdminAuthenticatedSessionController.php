<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\SocialProviderType;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;


class AdminAuthenticatedSessionController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver(SocialProviderType::GoogleAdmin->value)->redirect();
    }
    
    public function handleProviderCallback()
    {
        $socialiteUser = Socialite::driver(SocialProviderType::GoogleAdmin->value)->user();

        $user = User::where('provider_id', $socialiteUser->id)->first();

        if (!$user || !$user->isAdmin()) {
            return redirect()
                ->route('oauth.admin.top')
                ->with('error', 'You do not have permission to access this page.');
        }

        Auth::login($user, true);

        if (!$user->two_factor_enabled) {
            return $this->setup2FA();
        }

        session(['2fa_user_id' => $user->id]);
        return view('admin.auth.verify2fa');
    }

    private function setup2FA()
    {
        $user = Auth::user();

        $google2fa = app('pragmarx.google2fa');

        $secret = $google2fa->generateSecretKey();

        $user->two_factor_secret = $secret;
        $user->save();

        $qrCodeUrl = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->provider_id,
            $secret
        );

        return view('admin.auth.enable2fa', compact('qrCodeUrl'));
    }

    public function enable2FA(Request $request)
    {
        $user = Auth::user();

        $google2fa = app('pragmarx.google2fa');

        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->input('one_time_password'));

        if ($valid) {
            $user->two_factor_enabled = true;
            $user->save();

            return redirect()->route('admin.games.index');
        }

        return back()->withErrors(['one_time_password' => 'Invalid verification code']);
    }

    public function verify2FA(Request $request)
    {
        $google2fa = app('pragmarx.google2fa');

        $user = User::findOrFail(session('2fa_user_id'));

        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->input('one_time_password'));

        if ($valid) {
            Auth::login($user, true);

            session()->forget('2fa_user_id');
            
            return redirect()->route('admin.games.index');
        }

        return back()->withErrors(['one_time_password' => 'Invalid verification code']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('oauth.admin.top');
    }
}