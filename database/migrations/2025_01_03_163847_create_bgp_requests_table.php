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
            $table->enum('request_status', ["Pendente","Concluida","Rejeitada"])->default('Pendente');
            $table->uuid('token');
            $table->enum('router_table', ["Full Route","Partial Route","Default Route"])->default('Full Route')->nullable();
            $table->boolean('multihop')->default(false);
            $table->string('md5_session', 255)->nullable();
            $table->boolean('not_owner_as')->default(false);
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
