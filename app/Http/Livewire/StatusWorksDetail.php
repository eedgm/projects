<?php

namespace App\Http\Livewire;

use App\Models\Work;
use App\Models\Status;
use App\Models\Client;
use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StatusWorksDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Status $status;
    public Work $work;
    public $clientsForSelect = [];
    public $productsForSelect = [];
    public $workDateStart;
    public $workDateEnd;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Work';

    protected $rules = [
        'work.client_id' => ['required', 'exists:clients,id'],
        'work.product_id' => ['required', 'exists:products,id'],
        'workDateStart' => ['nullable', 'date'],
        'workDateEnd' => ['nullable', 'date'],
        'work.hours' => ['nullable', 'numeric'],
        'work.cost' => ['nullable', 'numeric'],
    ];

    public function mount(Status $status)
    {
        $this->status = $status;
        $this->clientsForSelect = Client::pluck('name', 'id');
        $this->productsForSelect = Product::pluck('name', 'id');
        $this->resetWorkData();
    }

    public function resetWorkData()
    {
        $this->work = new Work();

        $this->workDateStart = null;
        $this->workDateEnd = null;
        $this->work->client_id = null;
        $this->work->product_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newWork()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.status_works.new_title');
        $this->resetWorkData();

        $this->showModal();
    }

    public function editWork(Work $work)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.status_works.edit_title');
        $this->work = $work;

        $this->workDateStart = $this->work->date_start->format('Y-m-d');
        $this->workDateEnd = $this->work->date_end->format('Y-m-d');

        $this->dispatchBrowserEvent('refresh');

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

        if (!$this->work->statu_id) {
            $this->authorize('create', Work::class);

            $this->work->statu_id = $this->status->id;
        } else {
            $this->authorize('update', $this->work);
        }

        $this->work->date_start = \Carbon\Carbon::parse($this->workDateStart);
        $this->work->date_end = \Carbon\Carbon::parse($this->workDateEnd);

        $this->work->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Work::class);

        Work::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetWorkData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->status->works as $work) {
            array_push($this->selected, $work->id);
        }
    }

    public function render()
    {
        return view('livewire.status-works-detail', [
            'works' => $this->status->works()->paginate(20),
        ]);
    }
}
