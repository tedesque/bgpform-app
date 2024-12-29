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
        Schema::create('bgp_requests', function (Blueprint $table) {
            $table->id();
            $table->string('circuit_id', 200);
            $table->integer('circuit_speed');
            $table->enum('request_status', ["Pendente","Conclu\u00edda","Rejeitada"])->default('Pendente');
            $table->uuid('token');
            $table->string('device', 200)->nullable();
            $table->enum('router_table', ["full route","partial route","default route"])->default('full route')->nullable();
            $table->integer('asn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bgp_requests');
    }
};
