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
        Schema::create('documentstatus', function (Blueprint $table) {
            $table->id('StationID');
            $table->text('StationName');
            $table->unsignedBigInteger('Document_ID');
            $table->string('Status', 10);

            $table->foreign('Document_ID')->references('DocumentID')->on('document')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentstatus');
    }
};
