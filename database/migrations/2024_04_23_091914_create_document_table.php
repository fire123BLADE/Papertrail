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
        Schema::create('document', function (Blueprint $table) {
            $table->id('Document_ID');
            $table->string('Subject', 50);
            $table->string('Title', 15);
            $table->date('DateCreated');
            $table->unsignedBigInteger('User_ID');

            $table->foreign('UserID')->references('UserID')->on('sender')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
