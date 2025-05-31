<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::latest()->paginate(10);
        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        return view('admin.artists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'genre' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'gradient_start_color' => 'nullable|string|max:7',
            'gradient_end_color' => 'nullable|string|max:7',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('artists', 'public');
            $validated['image'] = $path;
        }

        // Set default gradient colors if not provided
        if (empty($validated['gradient_start_color'])) {
            $validated['gradient_start_color'] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }
        
        if (empty($validated['gradient_end_color'])) {
            $validated['gradient_end_color'] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }

        Artist::create($validated);

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artist created successfully.');
    }

    public function edit(Artist $artist)
    {
        return view('admin.artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'genre' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'gradient_start_color' => 'nullable|string|max:7',
            'gradient_end_color' => 'nullable|string|max:7',
        ]);

        if ($request->hasFile('image')) {
            if ($artist->image) {
                Storage::disk('public')->delete($artist->image);
            }
            $path = $request->file('image')->store('artists', 'public');
            $validated['image'] = $path;
        }

        $artist->update($validated);

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artist updated successfully.');
    }

    public function destroy(Artist $artist)
    {
        if ($artist->image) {
            Storage::disk('public')->delete($artist->image);
        }
        
        $artist->delete();

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artist deleted successfully.');
    }
} 