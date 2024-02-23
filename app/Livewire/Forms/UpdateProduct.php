<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateProduct extends Form
{
    //

    //todo Definimso las varaibles 

    public ?Product $producto = null; //? Importante definir una variable del propio objeto que vamos a actualiar y que pueda ser nula o no

    public string $nombre = "";

    public string $descripcion = "";

    public int $stock = 0;

    public float $pvp = 0;

    public array $tags = []; //? Defino un array vacia

    public $imagen;

    public function setProducto(Product $product)
    {

        //* LA IMAGEN NO SE SETEA

        $this->producto =  $product;
        $this->nombre = $product->nombre;
        $this->descripcion = $product->descripcion;
        $this->stock = $product->stock;
        $this->pvp = $product->pvp;
        //todo Tengo que hacer una funcion en el modelo, para que me devuelva los tags que tiene ese producto.
        $this->tags = $product->devolverTagsIds();
    }



    public function rules(){
        return [

            'nombre' =>  ['required' , 'string' , 'min:3' , 'unique:products,nombre,' . $this -> producto -> id ],
            'descripcion' => ['required' , 'string', 'min:10'],
            'stock' => ['required' , 'integer' , 'min:3'],
            'pvp' => ['required' , 'decimal:0,2' , 'min:0' , 'max:9999.99'],
            'tags' => ['required' , 'array' , 'min:2' , 'exists:tags,id'],
            'imagen' => ['nullable' , 'image' , 'max:2048'],
        ];
    }


    public function editarProducto(){
        //todo Comprobamos primero la foto

        $ruta = $this -> producto -> imagen;

        if ($this -> imagen){ //? Si se ha subido una imagen

            if (basename($ruta) != 'noimage.png'){ //? Comprobamos que la imagen actual del producto sea distinto a la default, si es distinta a la default:
                Storage::delete($ruta); //? La borramos
            }
            //? Almacenamos la imagen subida en la carpeta products con el nombre aleatorio y se almacena en la variable $ruta

            $ruta = $this -> imagen -> store('products');


        }

        $this -> producto -> update([

            'nombre' => $this -> nombre,
            'descripcion' => $this -> descripcion,
            'stock' => $this -> stock,
            'imagen' => $ruta,
            'disponible' => ($this -> stock > 0) ? 'SI' : 'NO',
            'user_id' => auth() -> user() -> id
        ]);

        $this -> producto -> tags() -> sync($this -> tags);

    }


    public function limpiarCampos(){
        $this -> reset(['nombre' , 'descripcion' , 'stock' , 'producto' , 'iamgen' , 'tags' , 'producto']);
    }

}
