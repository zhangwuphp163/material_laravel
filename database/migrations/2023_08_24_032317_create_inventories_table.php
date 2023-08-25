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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('material_id')->index();
            $table->unsignedInteger('asn_id')->index();
            $table->unsignedInteger('asn_item_id')->index();
            $table->unsignedInteger('order_id')->index()->nullable();
            $table->unsignedInteger('order_item_id')->index()->nullable();
            $table->decimal('unit_price',10,2)->default(0);
            $table->integer('qty')->default(0);
            $table->timestamp('inbound_at')->nullable();
            $table->timestamp('allocate_at')->nullable();
            $table->timestamp('outbound_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
