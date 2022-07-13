<?php

namespace App\Http\Livewire;

use App\Models\Field;
use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use App\Models\ProductDescription;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductProductDescriptionsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Product $product;
    public ProductDescription $productDescription;
    public $fieldsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ProductDescription';

    protected $rules = [
        'productDescription.label' => ['required', 'max:255', 'string'],
        'productDescription.field_id' => ['required', 'exists:fields,id'],
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->fieldsForSelect = Field::pluck('name', 'id');
        $this->resetProductDescriptionData();
    }

    public function resetProductDescriptionData()
    {
        $this->productDescription = new ProductDescription();

        $this->productDescription->field_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductDescription()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.product_product_descriptions.new_title'
        );
        $this->resetProductDescriptionData();

        $this->showModal();
    }

    public function editProductDescription(
        ProductDescription $productDescription
    ) {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.product_product_descriptions.edit_title'
        );
        $this->productDescription = $productDescription;

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

        if (!$this->productDescription->product_id) {
            $this->authorize('create', ProductDescription::class);

            $this->productDescription->product_id = $this->product->id;
        } else {
            $this->authorize('update', $this->productDescription);
        }

        $this->productDescription->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', ProductDescription::class);

        ProductDescription::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductDescriptionData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->product->productDescriptions as $productDescription) {
            array_push($this->selected, $productDescription->id);
        }
    }

    public function render()
    {
        return view('livewire.product-product-descriptions-detail', [
            'productDescriptions' => $this->product
                ->productDescriptions()
                ->paginate(20),
        ]);
    }
}
