<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LarasnapCreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('menu_id')->unsigned();
			$table->string('title');
			$table->string('icon')->comment('font icon class')->nullable();
			$table->bigInteger('parent_id')->nullable();
			$table->integer('order');
			$table->string('target')->default('_self');
			$table->string('url')->nullable();
			$table->string('route')->nullable();
			$table->string('route_parameter')->nullable();
            $table->timestamps();
			
			$table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
