<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //todo Llamamos al factory para crear los productos

       $producto = Product::factory(20) -> create();

       foreach ($producto as $item) {
        $item -> tags() -> attach(self::devolverTag());
       }



    }

    private static function devolverTag(){

        $tags = [];


        $idTablaTag = Tag::pluck('id') -> toArray(); //* Devuelve en un array todos los ids de la tabla Tag.

        $arrayIndicesRandom = array_rand($idTablaTag , random_int(2,count($idTablaTag)));


        foreach ($arrayIndicesRandom as $indice) {
            
            $tags[] = $idTablaTag[$indice];

        }

        return $tags;

    }
   
}
