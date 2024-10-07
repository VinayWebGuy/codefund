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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('role')->default(1);
            $table->string('unique_id')->unique();
            $table->float('wallet_balance')->default(0);
            $table->integer('keys_generated')->default(0);
            $table->string('pin_code')->nullable();
            $table->unsignedBigInteger('plan_id')->default(1);
            $table->string('identification_type')->nullable();
            $table->string('identification_number')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
