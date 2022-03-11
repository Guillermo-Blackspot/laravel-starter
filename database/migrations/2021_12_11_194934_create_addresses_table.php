<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('address');
            $table->string('city');
            $table->string('municipality');
            $table->text('references')->nullable();
            $table->integer('postal_code');
            $table->string('google_maps_link')->nullable();
            $table->boolean('main')->nullable()->default(false);
            $table->morphs('addressable');

            $table->foreignId('state_id')
                ->nullable()
                ->constrained('states')
                ->nullOnDelete();

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
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('state_id');
            $table->dropForeign(['state_id']);
        });
        Schema::dropIfExists('addresses');
    }
}
