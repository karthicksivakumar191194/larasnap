<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LarasnapCreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('label');
            $table->tinyInteger('is_parent')->default(1); //1 - Yes | 0 - No
            $table->unsignedBigInteger('parent_category_id')->nullable();
            $table->integer('position')->nullable();
            $table->tinyInteger('status')->default(1); //1 - Active | 0 - InActive
            $table->timestamps();
            
            $table->foreign('parent_category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('categories');
    }
}
