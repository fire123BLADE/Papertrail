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
        Schema::create('sender', function (Blueprint $table) {
            $table->unsignedBigInteger('Document_ID');
            $table->unsignedBigInteger('User_ID');
            $table->unsignedBigInteger('Station_ID');
            $table->unsignedBigInteger('Recipient_ID');
            $table->date('DateSent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sender');
    }
};
