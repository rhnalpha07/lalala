<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md bg-white shadow-2xl rounded-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Forgot Password</h2>
                
                <div class="mb-6 text-gray-600 text-center">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input 
                            id="email" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                   transition duration-300 ease-in-out" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus
                            placeholder="Enter your email address"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent 
                                                rounded-lg shadow-sm text-sm font-medium text-white 
                                                bg-blue-600 hover:bg-blue-700 focus:outline-none 
                                                focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                                transition duration-300 ease-in-out">
                            {{ __('Send Password Reset Link') }}
                        </x-primary-button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-600">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                Back to login
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
