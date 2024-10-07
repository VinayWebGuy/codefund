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
        Schema::create('payment_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_account_id');
            $table->unsignedBigInteger('for_user_id');
            $table->string('account_number');
            $table->float('amount');
            $table->unsignedBigInteger('generatedBy');
            $table->tinyInteger('status')->default(0);
            $table->dateTime('payment_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_links');
    }
};
