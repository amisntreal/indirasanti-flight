<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add pending_verification to enums
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'pending_verification', 'confirmed', 'cancelled') DEFAULT 'pending'");
        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_status ENUM('pending', 'pending_verification', 'paid', 'failed') DEFAULT 'pending'");

        // Add new columns to payments table
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'transaction_code')) {
                $table->string('transaction_code')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('payments', 'proof_of_payment')) {
                $table->string('proof_of_payment')->nullable()->after('transaction_code');
            }
            if (!Schema::hasColumn('payments', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('proof_of_payment');
            }
            if (!Schema::hasColumn('payments', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            }
        });

        // Add foreign key separately to ensure stability
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'verified_by')) {
                // Check if foreign key already exists (optional but safer)
                $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            }
        });

        // Fix proof_of_payment position if it was already there
        if (Schema::hasColumn('payments', 'proof_of_payment') && Schema::hasColumn('payments', 'transaction_code')) {
            DB::statement("ALTER TABLE payments MODIFY COLUMN proof_of_payment VARCHAR(255) NULL AFTER transaction_code");
        }
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['proof_of_payment', 'verified_at', 'verified_by']);
        });
    }
};
