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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('descriptions')->nullable();
            $table->unsignedBigInteger('typeDocumentId');
            $table->dateTime('dateOfPayment');
            $table->dateTime('dueDate');
            $table->decimal('value', 10, 2);
            $table->string('pathDocuments')->nullable();
            $table->foreign('typeDocumentId')->references('id')->on('type_documents')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
