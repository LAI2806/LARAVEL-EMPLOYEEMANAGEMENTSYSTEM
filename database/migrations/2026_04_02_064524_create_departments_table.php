<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Department ID
            $table->string('name'); // Department Name
            $table->text('description')->nullable(); // Description
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null'); // Manager ID
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};