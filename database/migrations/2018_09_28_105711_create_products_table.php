<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("invoice_id")->unsigned();
            $table->string("product_no",255);
            $table->string("product_desc",255);
            $table->integer("product_number")->unsigned();
            $table->integer("product_price")->unsigned();
            $table->timestamps();
            
            $table->foreign("invoice_id")->references("id")->on("invoice");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
