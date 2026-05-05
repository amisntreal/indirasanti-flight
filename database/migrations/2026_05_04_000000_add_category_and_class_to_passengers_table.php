<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->enum('passenger_type', ['adult', 'child', 'infant'])->after('gender')->default('adult');
            $table->enum('seat_class', ['economy', 'business', 'first_class'])->after('seat_number')->nullable();
            $table->decimal('price', 12, 2)->after('seat_class')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->dropColumn(['passenger_type', 'seat_class', 'price']);
        });
    }
};
