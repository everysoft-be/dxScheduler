<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create('everysoft_dxscheduler_schedulers', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->string('text_color')->nullable();
            $table->string('background_color')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->json('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists('everysoft_dxscheduler_schedulers');
    }
}
