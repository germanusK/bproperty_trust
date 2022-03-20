<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Customer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("customer", function(Blueprint $table){
            $table->engine = "InnoDB";
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->string("contact")->nullable();
            $table->timestamp("created_on")->useCurrent();
            $table->timestamp("last_updated_time")->useCurrent();
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
        Schema::dropIfExists("customer");
    }
}
