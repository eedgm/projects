<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('owner');
            $table->string('phone')->nullable();
            $table->string('name');
            $table->string('website', 250)->nullable();
            $table->string('logo', 250)->nullable();
            $table->text('direction')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->decimal('cost_hour');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
