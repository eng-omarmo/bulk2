<?php

namespace App\Livewire\OrganizationUser;

use App\Models\Activities;
use App\Models\OrganizationUser;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    public $username;

    public $email;

    public $password;

    public $organization_id;

    public $password_confirmation;

    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    public function render()
    {
        return view('livewire.organization-user.create');
    }

    public function save()
    {
        $this->validate([
            'username' => 'required|unique:organization_users,username',
            'email' => 'required|email|unique:organization_users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        // check if the user is already exist
        $user = OrganizationUser::where('email', $this->email)->first();
        if ($user) {
            session()->flash('error', 'User already exist.');

            return;
        }

        try {
            $user = $this->createUser();

            Activities::create([
                'organization_user_id' => auth()->user()->id,
                'action' => 'created',
                'description' => 'Created new user.'.$user->id.$user->name,
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong.');
        }
        $this->closeModal();
        $this->dispatch('userCreated')->to(Show::class);
    }

    public function createUser()
    {
        return OrganizationUser::create([
            'username' => $this->username,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'organization_id' => Auth()->user()->organization_id,
        ]);
    }
}
