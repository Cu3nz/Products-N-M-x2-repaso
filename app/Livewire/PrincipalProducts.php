<?php

namespace App\Livewire;

use App\Livewire\Forms\UpdateForm;
use App\Livewire\Forms\UpdateProduct;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PrincipalProducts extends Component
{

    use WithPagination;
    use WithFileUploads;

    //todo Para el info
    public Product $Producto;
    public bool $abrirModalInfo = false;


    //todo Para el update 

    public UpdateProduct $form;

    public bool $abrirModalUpdate = false;



    public string $buscar="";

    public string $orden = "desc";
    public string $campo = "id";

    public string $estado = "";

    #[On('refrescarTablaCreate')]

    public function render()
    {
        $productos = Product::with('user') -> where('user_id' , auth() -> user() -> id)
        ->where(function($q){
            $q -> where('nombre' , 'like' , "$this->buscar%")
            ->orWhere('disponible' , 'like' , "$this->buscar%");
        })
        ->orderBy($this -> campo , $this -> orden)
        ->paginate(5);
        $misTags = Tag::select('id' , 'nombre' , 'color') -> orderBy('nombre') -> get();
        return view('livewire.principal-products' , compact('productos' , 'misTags'));
    }


    public function actualizarDisponibleClick(Product $product){

        $estado = ($product -> disponible == 'NO') ? 'SI' : 'NO';

        $product -> update([
            'disponible' => $estado
        ]);

    }


    public function subirStock(Product $product){

        $stockActual = $product -> stock;

        $stockActual++;

        $product -> update([
            'stock' => $stockActual,
            'disponible' => ($stockActual > 0) ? 'SI' : 'NO'
        ]);

    }


    public function bajarStock(Product $product){

        if ($product -> stock > 0){

            $stockActual = $product -> stock;
    
            $stockActual--;

            $product -> update([
                'stock' => $stockActual,
                'disponible' => ($stockActual > 0) ? 'SI' : 'NO'
            ]);
        }

    }


    public function ordenar($campo){
        $this -> orden = ($this -> orden == 'asc') ? 'desc' : 'asc';

        $this -> campo = $campo;

    }

    public function updateBuscar(){
        $this -> resetPage();
    }


    

    public function pedirConfirmacion( Product $product){

        //dd($product -> id . "-" . auth() -> user() -> id);

        $this -> authorize('delete' , $product);
        
        $this -> dispatch('confirmarDelete' , $product -> id); //todo Este evento, lo va a escucahr app.blade.php
        
    }


    #[On('deleteConfirmado')]

    public function delete(Product $product){

        if(basename($product -> imagen) != 'noimagen.png'){
            Storage::delete($product -> imagen);
        }

        $product -> delete();

        $this -> dispatch('mensaje' , 'Producto eliminado correctamte');

    }


    //todo para el info

    public function info(Product $product){

        

        $this -> Producto = $product;

        $this -> abrirModalInfo = true;

    }

    public function salirModalInfo(){

        $this -> reset('abrirModalInfo' , 'Producto');

    }


    public function edit(Product $product){

        $this -> authorize('update' , $product);

        $this -> form  -> setProducto($product) ;

        $this -> abrirModalUpdate = true;

    }


    public function update(){
        $this -> form -> editarProducto(); //* Este metodo esta definido en UpdateForm

        $this -> salirModalUpdate();

        $this -> dispatch('mensaje' , 'Producto actualizado');

    }

    public function salirModalUpdate(){
        $this -> form -> limpiarCampos();

        $this -> abrirModalUpdate = false;

    }

}