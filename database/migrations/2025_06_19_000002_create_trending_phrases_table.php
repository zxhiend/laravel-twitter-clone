<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trending_phrases', function (Blueprint $table) {
            $table->id();
            $table->string('phrase')->unique();
            $table->unsignedBigInteger('count')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trending_phrases');
    }
};
