<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-default.input-label for="name" :value="__('Name')" />
            <x-default.text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-default.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-default.input-label for="email" :value="__('Email')" />
            <x-default.text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-default.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-default.input-label for="password" :value="__('Password')" />

            <x-default.text-input id="password" class="block w-full mt-1"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

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
            <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-default.primary-button class="ms-4">
                {{ __('Register') }}
            </x-default.primary-button>
        </div>
    </form>

    <!-- Separator between social media sign in and email/password sign in -->
    <div
        class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-neutral-300 after:mt-0.5 after:flex-1 after:border-t after:border-neutral-300 dark:before:border-neutral-500 dark:after:border-neutral-500">
        <p
            class="mx-4 mb-0 font-semibold text-center dark:text-white">
            or
        </p>
    </div>

    <!--Sign in section-->
    <div class="flex flex-col items-center justify-center space-y-8">
        <!-- X login -->
        <a class="flex items-center justify-center w-full py-2 space-x-2 border border-gray-600 rounded-md hover:bg-gray-700"
            href="{{ route('oauth.user.login', 'x') }}">
            <x-svg.x-icon />
            <p class="text-gray-400">Sign in with X</p>
        </a>

        <!-- Google login -->
        <a class="flex items-center justify-center w-full py-2 space-x-2 border border-gray-600 rounded-md hover:bg-gray-700"
            href="{{ route('oauth.user.login', 'google') }}">
            <x-svg.google-icon />
            <p class="text-gray-400">Sign in with Google</p>
        </a>
    </div>
</x-guest-layout>
