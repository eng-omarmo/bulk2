<?php

namespace App\Livewire\OrganizationUser;

use App\Models\OrganizationUser;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    public $user;

    public $username;

    public $email;

    public $password;

    public $password_confirmation;

    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    public function mount(OrganizationUser $user)
    {
        $this->user = $user;

        $this->username = $user->username;
        $this->email = $user->email;

    }

    public function render()
    {
        return view('livewire.organization-user.edit');
    }

    // update function with error handling
    public function update()
    {
        $this->validate([
            'username' => 'required|unique:organization_users,username,'.$this->user->id,
            'email' => 'required|email|unique:organization_users,email,'.$this->user->id,
            'password' => 'nullable|confirmed',
            'password_confirmation' => 'nullable|same:password',
        ]);

        try {
            $this->updateUser();
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong.');
        }

        $this->closeModal();
        $this->dispatch('userUpdated')->to(Show::class);
    }

    public function updateUser()
    {
        $this->user->update([
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password ? bcrypt($this->password) : $this->user->password,
        ]);
    }
}
