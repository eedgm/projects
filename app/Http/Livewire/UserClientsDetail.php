<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserClientsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public User $user;
    public Client $client;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Client';

    protected $rules = [
        'client.owner' => ['required', 'max:255', 'string'],
        'client.phone' => ['nullable', 'max:255', 'string'],
        'client.name' => ['required', 'max:255', 'string'],
        'client.website' => ['nullable', 'max:250', 'string'],
        'client.logo' => ['nullable', 'max:250', 'string'],
        'client.direction' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->resetClientData();
    }

    public function resetClientData()
    {
        $this->client = new Client();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newClient()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.user_clients.new_title');
        $this->resetClientData();

        $this->showModal();
    }

    public function editClient(Client $client)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.user_clients.edit_title');
        $this->client = $client;

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

        if (!$this->client->user_id) {
            $this->authorize('create', Client::class);

            $this->client->user_id = $this->user->id;
        } else {
            $this->authorize('update', $this->client);
        }

        $this->client->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Client::class);

        Client::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetClientData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->user->clients as $client) {
            array_push($this->selected, $client->id);
        }
    }

    public function render()
    {
        return view('livewire.user-clients-detail', [
            'clients' => $this->user->clients()->paginate(20),
        ]);
    }
}
