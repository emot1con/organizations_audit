<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_organizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('organization_roles')->cascadeOnDelete();
            
            // NULL = organization-level access
            $table->foreignId('division_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
            
            // Note: Mencegah user memiliki role ganda di divisi/organisasi yang sama
            $table->unique(['user_id', 'organization_id', 'division_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_organizations');
    }
};
