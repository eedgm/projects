<?php

namespace App\Http\Livewire;

use App\Models\Work;
use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WorkUsersDetail extends Component
{
    use AuthorizesRequests;

    public Work $work;
    public User $user;
    public $usersForSelect = [];
    public $user_id = null;

    public $showingModal = false;
    public $modalTitle = 'New User';

    protected $rules = [
        'user_id' => ['required', 'exists:users,id'],
    ];

    public function mount(Work $work)
    {
        $this->work = $work;
        $this->usersForSelect = User::pluck('name', 'id');
        $this->resetUserData();
    }

    public function resetUserData()
    {
        $this->user = new User();

        $this->user_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newUser()
    {
        $this->modalTitle = trans('crud.work_users.new_title');
        $this->resetUserData();

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        $this->authorize('create', User::class);

        $this->work->users()->attach($this->user_id, []);

        $this->hideModal();
    }

    public function detach($user)
    {
        $this->authorize('delete-any', User::class);

        $this->work->users()->detach($user);

        $this->resetUserData();
    }

    public function render()
    {
        return view('livewire.work-users-detail', [
            'workUsers' => $this->work
                ->users()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
