<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->timestamp('date_one')->nullable();
            $table->timestamp('date_two')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dates');
    }
};
