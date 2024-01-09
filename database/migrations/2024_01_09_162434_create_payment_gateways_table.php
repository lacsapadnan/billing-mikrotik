<?php

use App\Enum\PaymentGatewayStatus;
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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('username', 32);
            // barangkali akan support multiple payment gateway
            $table->string('gateway', 32)->default('xendit');
            $table->string('gateway_trx_id', 64);
            $table->integer('plan_id');
            $table->string('plan_name', 40);
            $table->integer('routers_id');
            $table->string('routers', 32);
            $table->string('price', 40);
            $table->string('pg_url_payment', 256);
            $table->string('payment_method', 32);
            $table->string('payment_channel', 32);
            $table->text('pg_request');
            $table->text('pg_paid_response');
            $table->dateTime('expired_date')->nullable();
            $table->dateTime('created_date');
            $table->dateTime('paid_date')->nullable();
            $table->tinyInteger('status')->default(PaymentGatewayStatus::UNPAID->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
