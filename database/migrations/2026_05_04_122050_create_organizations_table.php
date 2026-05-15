<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('owner_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('category_organizations')->nullable();
            $table->string('password_organizations')->nullable();
            $table->decimal('organizations_cash', 15, 2)->default(0);
            $table->string('contact')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void {
        Schema::dropIfExists('organizations');
    }
};
