<?php declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Auth\RoleType;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\SocialProviderType;
use Laravel\Socialite\Contracts\User as ContractsUser;


class UserLoginController extends Controller
{
    public function redirectToProvider(SocialProviderType $provider)
    {
        return Socialite::driver($provider->value)->redirect();
    }

    public function handleProviderCallback(SocialProviderType $provider)
    {
        $socialiteUser = Socialite::driver($provider->value)->user();

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
