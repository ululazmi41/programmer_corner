<?php

use App\Models\User;
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->ForeignIdFor(User::class, 'notifier_id')->constrained()->cascadeOnDelete();
            $table->morphs('notifiable');
            $table->boolean('read')->default(false);
            $table->enum('type', ['like', 'comment', 'follow', 'reply', 'promote', 'demote']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
