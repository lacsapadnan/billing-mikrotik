<?php

use App\Enum\ServiceType;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('username', 45)->unique();
            $table->string('password');
            $table->string('pppoe_password')->comment('For PPPOE Login');
            $table->string('fullname', 45);
            $table->mediumText('address')->nullable();
            $table->string('phonenumber', 20);
            $table->string('email', 128);
            $table->decimal('balance', 15, 2)->comment('For Money Deposit')->default(0);
            $table->enum('service_type', array_column(ServiceType::cases(), 'value'))->comment('for selecting user type');
            $table->boolean('auto_renewal')->comment('Auto renewall using balance')->default(true);
            $table->dateTime('last_login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
