<?php

namespace App\Http\Livewire;

use App\Models\Work;
use App\Models\Client;
use App\Models\Status;
use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductWorksDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Product $product;
    public Work $work;
    public $clientsForSelect = [];
    public $statusForSelect = [];
    public $workDateStart;
    public $workDateEnd;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Work';

    protected $rules = [
        'work.client_id' => ['required', 'exists:clients,id'],
        'workDateStart' => ['nullable', 'date'],
        'workDateEnd' => ['nullable', 'date'],
        'work.hours' => ['nullable', 'numeric'],
        'work.statu_id' => ['required', 'exists:status,id'],
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->clientsForSelect = Client::pluck('name', 'id');
        $this->statusForSelect = Status::pluck('name', 'id');
        $this->resetWorkData();
    }

    public function resetWorkData()
    {
        $this->work = new Work();

        $this->workDateStart = null;
        $this->workDateEnd = null;
        $this->work->client_id = null;
        $this->work->statu_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newWork()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.product_works.new_title');
        $this->resetWorkData();

        $this->showModal();
    }

    public function editWork(Work $work)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.product_works.edit_title');
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

        if (!$this->work->product_id) {
            $this->authorize('create', Work::class);

            $this->work->product_id = $this->product->id;
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

        foreach ($this->product->works as $work) {
            array_push($this->selected, $work->id);
        }
    }

    public function render()
    {
        return view('livewire.product-works-detail', [
            'works' => $this->product->works()->paginate(20),
        ]);
    }
}
