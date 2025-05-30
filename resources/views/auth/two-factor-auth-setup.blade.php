<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden transform transition-all">
                <div class="p-8">
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Two Factor Authentication</h2>
                    
                    <div class="mb-6">
                        @if(! auth()->user()->two_factor_secret)
                            <div class="text-gray-600 mb-4">
                                <p>Two factor authentication is not enabled yet. When enabled, you will be prompted for a secure, random token during authentication.</p>
                            </div>
                            
                            <form method="POST" action="{{ route('two-factor.enable') }}">
                                @csrf
                                
                                <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent 
                                                rounded-lg shadow-sm text-sm font-medium text-white 
                                                bg-blue-600 hover:bg-blue-700 focus:outline-none 
                                                focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                                transition duration-300 ease-in-out">
                                    {{ __('Enable Two-Factor Authentication') }}
                                </x-primary-button>
                            </form>
                        @else
                            <div class="text-gray-600 mb-4">
                                <p>Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application.</p>
                            </div>
                            
                            <div class="mt-4 mb-6 flex justify-center">
                                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                            </div>
                            
                            <div class="mb-6">
                                <div class="font-semibold text-gray-700 mb-2">Recovery Codes:</div>
                                <div class="bg-gray-100 p-4 rounded-lg">
                                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                        <div class="text-xs font-mono mb-1">{{ $code }}</div>
                                    @endforeach
                                </div>
                                <div class="mt-2 text-xs text-gray-500">
                                    Please store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.
                                </div>
                            </div>
                            
                            <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
                                <form method="POST" action="{{ route('two-factor.regenerate') }}" class="flex-1">
                                    @csrf
                                    
                                    <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent 
                                                    rounded-lg shadow-sm text-sm font-medium text-white 
                                                    bg-blue-600 hover:bg-blue-700 focus:outline-none 
                                                    focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                                    transition duration-300 ease-in-out">
                                        {{ __('Regenerate Recovery Codes') }}
                                    </x-primary-button>
                                </form>
                                
                                <form method="POST" action="{{ route('two-factor.disable') }}" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <x-secondary-button class="w-full flex justify-center py-3 px-4 border border-gray-300 
                                                       rounded-lg shadow-sm text-sm font-medium text-gray-700 
                                                       bg-white hover:bg-gray-50 focus:outline-none 
                                                       focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                                       transition duration-300 ease-in-out">
                                        {{ __('Disable Two-Factor Authentication') }}
                                    </x-secondary-button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 