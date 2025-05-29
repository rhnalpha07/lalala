<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorAuthController extends Controller
{
    /**
     * Show the 2FA setup page
     */
    public function show()
    {
        $user = auth()->user();
        
        if ($user->two_factor_secret) {
            return view('auth.two-factor.show');
        }
        
        // Generate new secret
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        
        // Save the secret
        $user->two_factor_secret = $secret;
        $user->save();
        
        // Generate QR code
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );
        
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($qrCodeUrl);
        
        return view('auth.two-factor.setup', [
            'secret' => $secret,
            'qrCode' => $qrCode,
        ]);
    }
    
    /**
     * Enable 2FA for the user
     */
    public function enable(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);
        
        $user = auth()->user();
        $google2fa = new Google2FA();
        
        // Verify the code
        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);
        
        if (!$valid) {
            throw ValidationException::withMessages([
                'code' => ['The provided two-factor authentication code was invalid.'],
            ]);
        }
        
        // Mark as confirmed
        $user->two_factor_confirmed_at = now();
        $user->save();
        
        return redirect()->route('profile.edit')->with('status', 'Two-factor authentication has been enabled.');
    }
    
    /**
     * Disable 2FA for the user
     */
    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);
        
        $user = auth()->user();
        
        // Disable 2FA
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();
        
        return redirect()->route('profile.edit')->with('status', 'Two-factor authentication has been disabled.');
    }
    
    /**
     * Generate recovery codes
     */
    public function generateRecoveryCodes()
    {
        $user = auth()->user();
        
        // Generate 8 recovery codes
        $recoveryCodes = [];
        for ($i = 0; $i < 8; $i++) {
            $recoveryCodes[] = bin2hex(random_bytes(8));
        }
        
        // Save recovery codes
        $user->two_factor_recovery_codes = json_encode($recoveryCodes);
        $user->save();
        
        return view('auth.two-factor.recovery-codes', [
            'recoveryCodes' => $recoveryCodes,
        ]);
    }
}
