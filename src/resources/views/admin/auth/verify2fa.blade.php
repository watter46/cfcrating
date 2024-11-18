<x-admin-guest-layout>
    <div class="relative w-full max-w-xl mx-auto overflow-hidden rounded-lg p-7">
        <!-- Background -->
        <x-ui.background.medium />

        <!-- Session Status -->
        <x-default.auth-session-status class="mb-4" :status="session('status')" />

        <div class="grid grid-cols-1 gap-16">
            <div class="mt-4">
                <p class="mb-2 text-sm text-gray-400">アプリに表示されている文字列を入力してください。30秒ごとに変わります。</p>
            </div>
            
            <form method="POST" action="{{ route('admin.verify2fa') }}">
                @csrf
                <div class="mt-4">
                    <input type="text" id="one_time_password" name="one_time_password" required
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <x-default.input-error :messages="$errors->first()" />
                @endif

                <div class="flex items-center justify-end mt-4">
                    <button class="px-2 py-1 rounded-lg bg-sky-600">
                        Confirm
                    </button>
                </div>
            </form>
            
            <div class="flex items-center justify-start mt-4">
                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-guest-layout>