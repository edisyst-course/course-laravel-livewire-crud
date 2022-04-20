<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductsForm extends Component
{
    use WithFileUploads;

    public $categories;
    public Product $product; // binding del Model Product come property del Livewire Component Products
    public $productCategories; // per gestire la select multipla e il Many To Many
    public $photo; // come per le categorie, è una proprietà di cui mi occupo separatamente in un secondo momento

    // Bisogna validare tutti i campi se uso il model binding: Product in questo caso
    protected $rules = [ // non mi accetta in_stock non checkato, lo vede come se fosse NULL
        'product.name' => 'required|min:5',
        'product.description' => 'required|max:500',
        'productCategories' => 'required|array',
        'product.color' => 'nullable|string',
        'product.in_stock' => 'boolean',
        'product.stock_date' => 'nullable|date',
        'photo' => 'required|image',
    ];

    //protected $messages = ['productCategories.required' => 'Categorie obbligatorie']
    protected $validationAttributes = [ // modifico il nome del field nell'error-message e non serve $messages
        'productCategories' => 'Categories'
    ];


    public function mount(Product $product) // glielo passo nell'edit, mentre è vuoto nel create
    {
        $this->categories = Category::all();
        $this->product = $product ?? new Product(); // binding del Model Product come property del Livewire Component Products
        $this->productCategories = $this->product->categories()->pluck('id');
    }


    public function render()
    {
        return view('livewire.products-form');
    }


    public function save()
    {
        $this->validate();

        // mi piacerebbe gestire anche l'assenza della foto
        $filename = $this->photo->store('products', 'public');
        $this->product->photo = $filename;

        $this->product->save();
        $this->product->categories()->sync($this->productCategories); // metodo x Many To Many

        return redirect()->route('products.index');
    }


    public function updatedProductName() // validazione in live time
    {
        $this->validateOnly('product.name');
    }
}
