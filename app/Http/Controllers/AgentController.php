<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    public function index()
    {
        $agents = User::where('role', 'agent')
                        ->latest()
                        ->paginate(10);

        return view('admin.agents.index', compact('agents'));
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
            'role' => 'agent',
            'profile_picture' => $profilePath,
        ]);

        return redirect()->route('admin.agents.index')
                        ->with('success', 'Agent registered successfully!');
    }

    public function update(Request $request, User $agent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$agent->id,
            'phone_number' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($agent->profile_picture) {
                Storage::disk('public')->delete($agent->profile_picture);
            }
            $profilePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $profilePath;
        }

        $agent->update($validated);

        return redirect()->route('admin.agents.index')
                        ->with('success', 'agent updated successfully!');
    }

    public function destroy(User $agent)
    {
        if ($agent->profile_picture) {
            Storage::disk('public')->delete($agent->profile_picture);
        }

        $agent->delete();

        return redirect()->route('admin.agents.index')
                        ->with('success', 'agent deleted successfully!');
    }
}
