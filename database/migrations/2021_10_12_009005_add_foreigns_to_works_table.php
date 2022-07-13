<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('works', function (Blueprint $table) {
            $table
                ->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('statu_id')
                ->references('id')
                ->on('statuses')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['statu_id']);
        });
    }
}
