<x-guest-layout>
    <div class="relative w-full max-w-xl mx-auto overflow-hidden rounded-lg p-7 bg-[#181a42]">
        <div class="mb-4 text-sm text-gray-400">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-default.input-label for="password" :value="__('Password')" />

                <x-default.text-input id="password" class="block w-full mt-1"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-default.input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-4">
                <x-default.primary-button>
                    {{ __('Confirm') }}
                </x-default.primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
