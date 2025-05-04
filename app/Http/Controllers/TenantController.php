<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = User::where('role', 'tenant')
                        ->latest()
                        ->paginate(10);

        return view('admin.tenants.index', compact('tenants'));
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
            'role' => 'tenant',
            'profile_picture' => $profilePath,
        ]);

        return redirect()->route('admin.tenants.index')
                        ->with('success', 'Tenant registered successfully!');
    }

    public function update(Request $request, User $tenant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$tenant->id,
            'phone_number' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($tenant->profile_picture) {
                Storage::disk('public')->delete($tenant->profile_picture);
            }
            $profilePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $profilePath;
        }

        $tenant->update($validated);

        return redirect()->route('admin.tenants.index')
                        ->with('success', 'Tenant updated successfully!');
    }

    public function destroy(User $tenant)
    {
        if ($tenant->profile_picture) {
            Storage::disk('public')->delete($tenant->profile_picture);
        }

        $tenant->delete();

        return redirect()->route('admin.tenants.index')
                        ->with('success', 'Tenant deleted successfully!');
    }
}
