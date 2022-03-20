<?php

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // this model is going to be applicable for a search without the 'description' and 'placed_by' fields
        Schema::create("order", function(Blueprint $table){
            $table->engine = "InnoDB";
            $table->id();
            $table->string("category");
            $table->timestamp("created_on")->useCurrent();
            $table->string("description"); //concise description of expected item
            $table->unsignedBigInteger("placed_by"); //the id of the customer placing the order.
            $table->enum("status", ["pending", "acheived"])->default("pending");//if order is pending or achieved
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("order");
    }
}
