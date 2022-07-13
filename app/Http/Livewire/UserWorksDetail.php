<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Work;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserWorksDetail extends Component
{
    use AuthorizesRequests;

    public User $user;
    public Work $work;
    public $worksForSelect = [];
    public $work_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Work';

    protected $rules = [
        'work_id' => ['required', 'exists:works,id'],
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->worksForSelect = Work::pluck('date_start', 'id');
        $this->resetWorkData();
    }

    public function resetWorkData()
    {
        $this->work = new Work();

        $this->work_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newWork()
    {
        $this->modalTitle = trans('crud.user_works.new_title');
        $this->resetWorkData();

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

        $this->authorize('create', Work::class);

        $this->user->works()->attach($this->work_id, []);

        $this->hideModal();
    }

    public function detach($work)
    {
        $this->authorize('delete-any', Work::class);

        $this->user->works()->detach($work);

        $this->resetWorkData();
    }

    public function render()
    {
        return view('livewire.user-works-detail', [
            'userWorks' => $this->user
                ->works()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
