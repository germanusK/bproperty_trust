<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Property extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("property", function(Blueprint $table){
            $table->engine = "InnoDB";
            $table->id();
            $table->string("name");
            $table->string("group");//whether real estate or general commerce item
            $table->string("category"); //say electronics, cloth, wearables, house|land|etc
            $table->string("description")->nullable(); //concise description of the item e.g house properties and facilities.
            $table->text("images");//will have to store >=1 image of the item
            $table->string("grade");//give the item a grade that boosts its priority to be presented on site.
            $table->string("price");//price per item.
            $table->timestamp("created_at")->useCurrent();//time stamp on which the asset was uplaoded
            $table->timestamp("updated_at")->useCurrent();
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
        Schema::dropIfExists("property");
    }
}
