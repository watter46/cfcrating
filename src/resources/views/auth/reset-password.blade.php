<x-guest-layout>
    <div class="relative w-full max-w-xl mx-auto overflow-hidden rounded-lg p-7 bg-[#181a42]">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-default.input-label for="email" :value="__('Email')" />
                <x-default.text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-default.input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-default.input-label for="password" :value="__('Password')" />
                <x-default.text-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
                <x-default.input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-default.input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-default.text-input id="password_confirmation" class="block w-full mt-1"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                <x-default.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-default.primary-button>
                    {{ __('Reset Password') }}
                </x-default.primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
