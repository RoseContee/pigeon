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
            $table->string('email', 80)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('membership_id');
            $table->integer('limitation');
            $table->integer('event');
            $table->integer('schedule');
            $table->date('start_date');
            $table->date('end_date');
            $table->bigInteger('booking_number')->default(0);
            $table->tinyInteger('two_days')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->string('api_token')->nullable();
            $table->string('google_id')->nullable();
            $table->text('avatar')->nullable();
            $table->string('slug')->nullable()->unique();
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
