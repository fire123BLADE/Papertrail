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
        Schema::create('recipient', function (Blueprint $table) {
            $table->id('Recipient_ID');
            $table->unsignedBigInteger('Document_ID');
            $table->dateTime('DateReceived');
            $table->text('RoleDepartment');

            $table->foreign('Document_ID')->references('DocumentID')->on('document')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipient');
    }
};
