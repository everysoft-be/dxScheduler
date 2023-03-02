<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create('everysoft_scheduler_events', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->text('description')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->boolean('all_day')->default(false);
            $table->foreignid('category_id')->nullable()->constrained('everysoft_scheduler_categories');
            $table->string('recurrence_rule')->nullable();
            $table->string('recurrence_exception')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('scheduler_id')->constrained('everysoft_scheduler_schedulers');
            $table->foreignId('parent_id')->nullable()->constrained('everysoft_scheduler_events');
            $table->string('object_class')->nullable();
            $table->enum('status', ['UNKNOWN', 'ACCEPTED', 'REFUSED', 'WAITING']);
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
        Schema::dropIfExists('everysoft_scheduler_events');
    }
}
