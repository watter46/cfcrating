<x-guest-layout>
    <div class="relative w-full max-w-xl mx-auto overflow-hidden rounded-lg p-7 bg-[#181a42]">
        <div class="mb-4 text-sm text-gray-400">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-default.auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-default.input-label for="email" :value="__('Email')" />
                <x-default.text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
                <x-default.input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-default.primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-default.primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
