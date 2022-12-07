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
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('email_2')->nullable();
            $table->string('landline')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('photo')->nullable();
            $table->char('gender',1)->nullable();
            $table->boolean('accept_terms')->nullable()->default(1);
            $table->boolean('is_active')->nullable()->default(1);
            $table->string('password')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('parent_owner')->nullable();
            $table->string('partner_code')->unique()->nullable();
            $table->string('active_campaign_contact_id')->nullable();
            $table->text('about_me')->nullable();
            $table->timestamp('email_verification_date')->nullable();
            $table->rememberToken();
            
            $table->foreignId('cellphone_code_id')
                ->nullable()
                ->constrained('countries')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['cellphone_code_id']);
            $table->dropColumn('cellphone_code_id');
        });

        Schema::dropIfExists('users');
    }
}
