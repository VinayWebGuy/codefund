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
        Schema::create('apis', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('key')->unique();
            $table->string('api_quota')->default('limited');
            $table->integer('total_requests')->nullable();
            $table->tinyInteger('extra_secure')->default(0);
            $table->string("security_header")->nullable();
            $table->integer('request_hit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apis');
    }
};
