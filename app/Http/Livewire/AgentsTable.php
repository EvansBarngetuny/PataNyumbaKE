<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AgentsTable extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;

    public $selectedUserId;
    public $editModalOpen = false;
    public $deleteModalOpen = false;

    public $user = [
        'name' => '',
        'email' => '',
        'phone_number' => '',
        'role' => 'agent',
        'profile_picture' => null,
    ];
    public $newProfilePicture;
    public $currentProfilePicture;

    protected $rules = [
        'user.name' => 'required|string|max:255',
        'user.email' => 'required|email|unique:users,email',
        'user.phone_number' => 'required|string|max:20',
        'user.role' => 'required|in:landlord,agent',
        'newProfilePicture' => 'nullable|image|max:2048',
    ];
    public $createModalOpen = false;
    public $name;
    public $email;
    public $phone_number;
    public $role = 'agent';
    public $password;

    protected $listeners = [
        'openCreateModal' => 'openCreateModal',
    ];

    public function openCreateModal()
    {
        $this->reset(['name', 'email', 'phone_number', 'password']); // Clear form fields
        $this->createModalOpen = true;
    }

    public function createAgent()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
            'password' => bcrypt($this->password),
        ]);

        $this->reset(['name', 'email', 'phone_number', 'password']);
        $this->createModalOpen = false;
        $this->emit('refreshTable');
    }

    public function mount()
    {
        $this->rules['user.email'] = 'required|email|unique:users,email';
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function openEditModal($userId)
    {
        $this->selectedUserId = $userId;
        $user = User::findOrFail($userId);

        $this->user = [
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'role' => $user->role,
            'profile_picture' => $user->profile_picture,
        ];

        $this->currentProfilePicture = $user->profile_picture
            ? asset('storage/'.$user->profile_picture)
            : null;

        $this->rules['user.email'] = 'required|email|unique:users,email,'.$userId;
        $this->editModalOpen = true;
        $this->newProfilePicture = null;
    }

    public function openDeleteModal($userId)
    {
        $this->selectedUserId = $userId;
        $this->deleteModalOpen = true;
    }

    public function updateUser()
    {
        $this->validate();

        $user = User::findOrFail($this->selectedUserId);

        $updateData = [
            'name' => $this->user['name'],
            'email' => $this->user['email'],
            'phone_number' => $this->user['phone_number'],
            'role' => $this->user['role'],
        ];

        if ($this->newProfilePicture) {
            // Delete old profile picture if exists
            if ($this->user['profile_picture']) {
                Storage::delete($this->user['profile_picture']);
            }

            $path = $this->newProfilePicture->store('profile-pictures', 'public');
            $updateData['profile_picture'] = $path;
        }

        $user->update($updateData);

        $this->editModalOpen = false;
        $this->reset(['user', 'newProfilePicture', 'currentProfilePicture']);
        session()->flash('message', 'User updated successfully.');
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->selectedUserId);

        // Delete profile picture if exists
        if ($user->profile_picture) {
            Storage::delete($user->profile_picture);
        }

        $user->delete();

        $this->deleteModalOpen = false;
        session()->flash('message', 'User deleted successfully.');
    }

    public function render()
    {
        $agents = User::where('role', 'agent')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhere('phone_number', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.agents-table', [
            'agents' => $agents,
        ]);
    }
}
