<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LarasnapCreateRoleScreenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_screen', function (Blueprint $table) {
			$table->bigInteger('role_id')->unsigned();
            $table->bigInteger('screen_id')->unsigned();
			
			$table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('screen_id')
                ->references('id')
                ->on('screens')
                ->onDelete('cascade');
				
			$table->primary(['role_id', 'screen_id']);	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_screen');
    }
}
