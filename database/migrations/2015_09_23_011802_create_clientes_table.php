<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id_cliente');
            $table->string('nombre');
            $table->text('direccion');
            $table->string('telefono');
            $table->string('celular');
            $table->string('numero_elector');
            $table->string('nombre_referencia_1');
            $table->string('telefono_referencia_1');
            $table->string('nombre_referencia_2');
            $table->string('telefono_referencia_2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clientes');
    }
}
