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
        Schema::create('asns', function (Blueprint $table) {
            $table->id();
            $table->string('asn_number')->unique();
            $table->string('status',32)->index();
            $table->string('remarks')->nullable();
            $table->timestamp('inbound_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asns');
    }
};
