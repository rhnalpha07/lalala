<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md bg-white shadow-2xl rounded-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-center text-indigo-800 mb-6">Admin Login</h2>
                
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input 
                            id="email" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   transition duration-300 ease-in-out" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="username" 
                            placeholder="Enter your email"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input 
                            id="password" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   transition duration-300 ease-in-out" 
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password" 
                            placeholder="Enter your password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                name="remember"
                            >
                            <label for="remember_me" class="ms-2 block text-sm text-gray-900">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        @if (Route::has('admin.password.request'))
                            <a 
                                href="{{ route('admin.password.request') }}" 
                                class="text-sm text-indigo-600 hover:text-indigo-800 transition duration-300"
                            >
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent 
                                                rounded-lg shadow-sm text-sm font-medium text-white 
                                                bg-indigo-600 hover:bg-indigo-700 focus:outline-none 
                                                focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                                                transition duration-300 ease-in-out">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout> 