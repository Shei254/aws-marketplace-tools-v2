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
        Schema::create('aws_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("aws_customer_id");
            $table->string("dimension");
            $table->unsignedInteger("quantity")->default(0);
            $table->timestamps();

            $table->foreign("aws_customer_id")->references("id")->on("aws_customers")->onDelete("CASCADE")->onUpdate("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aws_subscriptions');
    }
};
