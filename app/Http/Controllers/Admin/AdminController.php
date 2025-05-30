<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $stats = [
            'total_events' => \App\Models\Event::count(),
            'total_artists' => \App\Models\Artist::count(),
            'total_users' => \App\Models\User::count(),
            'upcoming_events' => \App\Models\Event::where('status', 'upcoming')->count(),
        ];

        $latest_events = \App\Models\Event::with('artist')
            ->latest()
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact('stats', 'latest_events'));
    }

    /**
     * Display the admin profile page.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('admin.profile', [
            'admin' => Auth::guard('admin')->user(),
        ]);
    }

    /**
     * Update the admin's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,' . $admin->id],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // If the admin is changing their email, we need to verify it hasn't been taken
        if ($request->email !== $admin->email) {
            $admin->email = $request->email;
        }
        
        $admin->name = $request->name;

        // Only update the password if one is provided
        if ($request->filled('password')) {
            // Verify the current password
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors([
                    'current_password' => __('The provided password does not match your current password.'),
                ]);
            }

            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('status', 'profile-updated');
    }
} 