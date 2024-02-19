<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table -> string('nombre') -> unique();
            $table -> text('descripcion');
            $table -> integer('stock');
            $table -> float('pvp' , 6,2);
            $table -> enum('disponible' , ['SI' , 'NO']);
            $table -> string('imagen');
            //? Llave foranea con relacion 1:N, user_id
            $table -> foreignId('user_id') -> constrained() -> onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
