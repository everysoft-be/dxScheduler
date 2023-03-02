<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create('everysoft_scheduler_categories', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('text_color')->nullable();
            $table->string('background_color')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('scheduler_id')->nullable()->constrained('everysoft_scheduler_schedulers');
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
        Schema::dropIfExists('everysoft_scheduler_categories');
    }
}
