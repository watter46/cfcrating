<?php declare(strict_types=1);

namespace App\Http\Controllers\User;

use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as ContractsUser;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\SocialProviderType;
use App\Http\Controllers\Auth\RoleType;


class UserLoginController extends Controller
{
    public function redirectToProvider(SocialProviderType $provider)
    {
        return Socialite::driver($provider->value)->redirect();
    }

    public function handleProviderCallback(SocialProviderType $provider)
    {
        try {
            $socialiteUser = Socialite::driver($provider->value)->user();
        } catch (\Exception $e) {
            return redirect()
                ->route('login')
                ->with('error', 'login was canceled or failed.');
        }

        $user = $this->findOrCreateUser($socialiteUser, $provider);

        Auth::login($user, true);

        return redirect()->route('games.index');
    }

    private function findOrCreateUser(ContractsUser $socialiteUser, SocialProviderType $provider)
    {
        $user = User::where('provider_id', $socialiteUser->id)->first();

        if ($user) {
            return $user;
        }

        return User::create([
            'name' => $socialiteUser->name,
            'provider' => $provider->value,
            'provider_id' => $socialiteUser->id,
            'role' => RoleType::User->value
        ]);
    }
}
