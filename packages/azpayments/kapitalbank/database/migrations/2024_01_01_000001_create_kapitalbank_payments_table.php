<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kapitalbank_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->unique();
            $table->string('password');
            $table->string('secret')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('AZN');
            $table->string('status')->default('Preparing');
            $table->string('type')->default('Order_SMS');
            $table->string('approval_code')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('rrn')->nullable();
            $table->string('card_mask')->nullable();
            $table->string('card_brand')->nullable();
            $table->unsignedBigInteger('stored_token_id')->nullable();
            $table->string('description')->nullable();
            $table->string('language', 2)->default('az');
            $table->string('error_code')->nullable();
            $table->text('error_message')->nullable();
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('meta')->nullable();
            $table->json('response')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('user_id');
            $table->index(['reference_type', 'reference_id']);
        });

        Schema::create('kapitalbank_saved_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('stored_token_id')->unique();
            $table->string('card_mask');
            $table->string('card_brand')->nullable();
            $table->string('expiration')->nullable();
            $table->string('display_name')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kapitalbank_saved_cards');
        Schema::dropIfExists('kapitalbank_payments');
    }
};