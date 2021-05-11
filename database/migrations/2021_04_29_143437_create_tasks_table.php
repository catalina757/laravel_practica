<?php

use App\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('board_id')->nullable();
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('assignment')->nullable();
            $table->foreign('assignment')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('status')->default(\App\Models\Task::STATUS_CREATED);
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
        Schema::dropIfExists('tasks');
    }
}