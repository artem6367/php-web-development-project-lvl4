<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('task_statuses')->onDelete('restrict');
            $table->bigInteger('created_by_id')->unsigned();
            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('restrict');
            $table->bigInteger('assigned_to_id')->nullable()->unsigned();
            $table->foreign('assigned_to_id')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
