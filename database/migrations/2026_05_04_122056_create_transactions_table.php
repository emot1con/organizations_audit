<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            // division_id penting untuk scoping jika transaksi ada di level divisi
            $table->foreignId('division_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('category');
            
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->string('proof_url')->nullable();
            
            $table->string('status')->default('pending'); // pending, approved, rejected
            
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->date('transaction_date');
            $table->timestamp('approved_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
