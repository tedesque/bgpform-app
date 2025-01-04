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
        Schema::disableForeignKeyConstraints();

        Schema::create('asn_entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('asn_entities')->cascadeOnDelete();
            $table->foreignId('bgp_request_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('asn');
            $table->string('as_set', 200)->nullable();
            $table->string('tech_name', 200)->nullable();
            $table->string('tech_phone', 30)->nullable();
            $table->string('tech_mail', 200)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asn_entities');
    }
};
