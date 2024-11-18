<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Disconnect Social Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Ensure your email address and password are registered before disconnecting your social account.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.disconnect') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        @if($user->provider === 'google')
            <div class="flex items-center justify-center space-x-2 w-fit">
                <p class="text-lg text-gray-400">Google</p>

                <x-svg.google-icon />
            </div>
        @else
            <div class="flex items-center justify-center space-x-2 w-fit">
                <p class="text-lg text-gray-400">X</p>

                <x-svg.x-icon />
            </div>
        @endif

        <x-default.input-error :messages="$errors->get('provider')" class="mt-2" />

        <div class="flex justify-start mt-6">
            <x-default.warning-button>
                {{ __('Disconnect Social Account') }}
            </x-default.warning-button>
        </div>
    </form>
</section>