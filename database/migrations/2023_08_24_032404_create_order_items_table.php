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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->index();
            $table->unsignedInteger('sku_id')->index();
            $table->unsignedInteger('plan_qty')->default(0);
            $table->unsignedInteger('actual_qty')->default(0);
            $table->decimal('plan_unit_price',10,2)->default(0);
            $table->decimal('actual_unit_price',10,2)->default(0);
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
        Schema::dropIfExists('order_items');
    }
};
