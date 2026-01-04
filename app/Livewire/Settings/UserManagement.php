<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Models\User;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showCreateModal = false;
    public bool $showEditModal = false;

    // Form fields
    public ?int $editingUserId = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'staff';

    protected $listeners = ['refreshUsers' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role', 'editingUserId']);
        $this->showCreateModal = true;
    }

    public function closeCreateModal(): void
    {
        $this->showCreateModal = false;
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role']);
    }

    public function createUser(): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,staff',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        session()->flash('success', 'User created successfully!');
        $this->closeCreateModal();
    }

    public function editUser(int $userId): void
    {
        $user = User::findOrFail($userId);
        
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role ?? 'staff';
        $this->password = '';
        $this->password_confirmation = '';
        
        $this->showEditModal = true;
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role', 'editingUserId']);
    }

    public function updateUser(): void
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->editingUserId,
            'role' => 'required|in:admin,manager,staff',
        ];

        if ($this->password) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $validated = $this->validate($rules);

        $user = User::findOrFail($this->editingUserId);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if ($this->password) {
            $user->update(['password' => Hash::make($this->password)]);
        }

        session()->flash('success', 'User updated successfully!');
        $this->closeEditModal();
    }

    public function deleteUser(int $userId): void
    {
        // Only admin can delete users
        if (!RoleMiddleware::canManageUsers(Auth::user()->role)) {
            session()->flash('error', 'You do not have permission to delete users!');
            return;
        }

        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account!');
            return;
        }

        $user->delete();
        session()->flash('success', 'User deleted successfully!');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.settings.user-management', [
            'users' => $users,
            'canManageUsers' => RoleMiddleware::canManageUsers(Auth::user()->role),
            'availableRoles' => RoleMiddleware::getAllRoles(),
        ]);
    }
}
