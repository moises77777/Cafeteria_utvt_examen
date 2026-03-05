<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_tipo_comidas', function (Blueprint $table) {
            $table->enum('nombre_categoria', ['Bebidas', 'Postres', 'Platillos Fuertes', 'Entradas', 'Sopas', 'Entremeses', 'Pan'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('tb_tipo_comidas', function (Blueprint $table) {
            $table->enum('nombre_categoria', ['Bebidas', 'Postres', 'Platillos Fuertes', 'Entradas', 'Sopas', 'Entremeses'])->change();
        });
    }
};
