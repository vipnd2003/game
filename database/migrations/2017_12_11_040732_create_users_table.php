<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
            $table->string('code');
			$table->integer('level')->default(0)->nullable();
            $table->integer('xp')->default(0)->nullable();
			$table->integer('gold')->default(0)->nullable();
            $table->integer('map_id')->default(0)->nullable();
			$table->string('api_key')->nullable();
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
		Schema::drop('users');
    }
}
