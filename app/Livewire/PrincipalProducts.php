<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PrincipalProducts extends Component
{

    use WithPagination;

    //todo Para el info
    public Product $Producto;
    public bool $abrirModalInfo = false;


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
        return view('livewire.principal-products' , compact('productos'));
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


}