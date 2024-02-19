<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearProducts extends Component
{

    use WithFileUploads;

    public bool $abrirModalCreate = false;

    #[Validate(['required' , 'string' , 'min:3' , 'unique:products,nombre'])]
    public string $nombre = "";
    #[Validate(['required' , 'string', 'min:10'])]
    public string $descripcion= "";

    #[Validate(['required' , 'integer' , 'min:3'])]
    public int $stock = 0;

    #[Validate(['required' , 'decimal:0,2' , 'min:0' , 'max:9999.99'])]
    public float $pvp = 0;

    #[Validate(['required' , 'array' , 'min:2' , 'exists:tags,id'])]
    public array $tags = []; 

    #[Validate(['nullable' , 'image' , 'max:2048'])]
    public $imagen;




    public function render()
    {
        $misTags = Tag::select('id' , 'nombre' , 'color') -> orderBy('nombre') -> get();
        return view('livewire.crear-products' , compact('misTags'));
    }



    public function store(){
        $this -> validate();


        $productoCreado = Product::create([

            'nombre' => $this -> nombre,
            'descripcion' => $this -> descripcion,
            'stock' => $this -> stock,
            'imagen' => ($this -> imagen) ? $this -> imagen -> store('products') : 'noimage.png',
            'pvp' => $this -> pvp,
            'disponible' => ($this -> stock > 0) ? 'SI' : 'NO',
            'user_id' => auth() -> user() -> id
        ]);

        $productoCreado -> tags() -> attach($this -> tags);        //? Añadimos los tags que se han seleccionado en el formulario al producto que se va a crear

        //todo Evento que solo lo va a escuchar PrincipalProducts:

        $this -> dispatch('refrescarTablaCreate') -> to(PrincipalProducts::class);

        $this -> dispatch('mensaje' , 'Producto creado correctamente');

        $this -> salirModalCreate();

    }


    public function salirModalCreate(){
        $this -> reset(['nombre' , 'descripcion' , 'stock' , 'pvp' , 'imagen' , 'tags' , 'abrirModalCreate']);
    }


}
