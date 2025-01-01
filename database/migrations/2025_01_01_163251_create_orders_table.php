<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('delivery_address');
            $table->decimal('delivery_price');
            $table->time('delivery_time')->default('00:00:00');
            $table->date('delivery_date')->default('2000-01-01');
            $table->decimal('item_price');
            $table->string('notes');
            $table->longText('description')->nullable();
            $table->enum('status', ['new', 'processing', 'delivered', 'cancelled'])->default('new');
            $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete();
            $table->foreignId('delivery_man_id')->nullable()->constrained('delivery_men')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
