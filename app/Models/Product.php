<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['nombre' , 'descripcion' , 'stock' , 'pvp' , 'disponible' , 'imagen' , 'user_id'];

    //! Relaciones 

    //todo Un producto Cuantas etiquetas peude tener? Muchas

    public function tags(){
        return $this -> belongsToMany(Tag::class);
    }

    //todo Un producto cuantos usuarios puede tener? 1

    public function user(){
        return $this -> belongsTo(User::class);
    }



    public function nombre(){
        return Attribute::make(
            set: fn($v) => ucfirst($v)
        );
    }
    public function descripcion(){
        return Attribute::make(
            set: fn($v) => ucfirst($v)
        );
    }



    public function devolverTagsIds(){
        // Inicializa un arreglo vacío llamado $tags.
        $tags = [];
    
        // Itera sobre cada etiqueta asociada al producto mediante el método tags().
        // Este método se asume que devuelve una colección de objetos etiqueta (tag) asociados al producto.
        foreach ($this->tags as $tag) {
            // Agrega el identificador (id) de cada etiqueta al arreglo $tags.
            // Esto significa que se está añadiendo el id de cada tag al final del arreglo $tags.
            $tags[] = $tag->id; 
        }
    
        // Devuelve el arreglo $tags, que ahora contiene los IDs de todas las etiquetas asociadas al producto.
        return $tags;
    }
    
    


}
