<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('employee_id');

        $table->date('attendance_date');
        $table->time('time_in')->nullable();
        $table->time('time_out')->nullable();

        $table->string('status')->nullable();
        $table->text('remarks')->nullable();

        $table->timestamps();

        // Foreign Key (IMPORTANT)
        $table->foreign('employee_id')
              ->references('id')
              ->on('employees')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
