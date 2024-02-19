<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['nombre' , 'color'];


    //todo Una etiqueta en cuantos productos puede estar? En muchos 

    public function products(){
        return $this -> belongsToMany(Product::class);
    }


    public function nombre(){
        return Attribute::make(
            set: fn($v) => ucfirst("#$v")
        );
    }



}
