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
        Schema::create('archive', function (Blueprint $table) {
            $table->id('Document_ID');
            $table->string('Subject', 50);
            $table->unsignedBigInteger('RecipientID');
            $table->dateTime('DateModified');
            $table->unsignedBigInteger('Station_ID');
    

            $table->foreign('RecipientID')->references('Recipient_ID')->on('recipient')->onUpdate('cascade');
            $table->foreign('Station_ID')->references('StationID')->on('documentstatus')->onUpdate('cascade');
            $table->foreign('Document_ID')->references('DocumentID')->on('document')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive');
    }
};
