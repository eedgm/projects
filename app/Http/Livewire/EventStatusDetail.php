<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\Status;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventStatusDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Event $event;
    public Status $status;
    public $clientsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Status';

    protected $rules = [
        'status.name' => ['required', 'max:255', 'string'],
        'status.color' => ['required'],
        'status.client_id' => ['required', 'exists:clients,id'],
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->clientsForSelect = Client::pluck('name', 'id');
        $this->resetStatusData();
    }

    public function resetStatusData()
    {
        $this->status = new Status();

        $this->status->client_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newStatus()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.event_status.new_title');
        $this->resetStatusData();

        $this->showModal();
    }

    public function editStatus(Status $status)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.event_status.edit_title');
        $this->status = $status;

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

        if (!$this->status->event_id) {
            $this->authorize('create', Status::class);

            $this->status->event_id = $this->event->id;
        } else {
            $this->authorize('update', $this->status);
        }

        $this->status->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Status::class);

        Status::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetStatusData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->event->statuses as $status) {
            array_push($this->selected, $status->id);
        }
    }

    public function render()
    {
        return view('livewire.event-status-detail', [
            'statuses' => $this->event->statuses()->paginate(20),
        ]);
    }
}
