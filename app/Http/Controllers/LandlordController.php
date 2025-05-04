<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LandlordController extends Controller
{
    public function index()
    {
        $landlords = User::where('role', 'landlord')
                        ->latest()
                        ->paginate(10);

        return view('admin.landlords.index', compact('landlords'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $profilePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'role' => 'landlord',
            'profile_picture' => $profilePath,
        ]);

        return redirect()->route('admin.landlords.index')
                        ->with('success', 'Landlord registered successfully!');
    }

    public function update(Request $request, User $landlord)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$landlord->id,
            'phone_number' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($landlord->profile_picture) {
                Storage::disk('public')->delete($landlord->profile_picture);
            }
            $profilePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $profilePath;
        }

        $landlord->update($validated);

        return redirect()->route('admin.landlords.index')
                        ->with('success', 'Landlord updated successfully!');
    }

    public function destroy(User $landlord)
    {
        if ($landlord->profile_picture) {
            Storage::disk('public')->delete($landlord->profile_picture);
        }

        $landlord->delete();

        return redirect()->route('admin.landlords.index')
                        ->with('success', 'Landlord deleted successfully!');
    }
}