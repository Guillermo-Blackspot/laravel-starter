<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('photo')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->char('gender',1)->nullable();
            $table->string('email')->unique();
            $table->date('birthday_date')->nullable();
            $table->boolean('vip')->nullable()->default(0);
            $table->string('password');
            $table->string('slug')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
