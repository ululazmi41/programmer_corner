<?php

use App\Models\Chat\Conversation;
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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('set null');
            $table->ForeignIdFor(Conversation::class)->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->boolean('is_system')->default(false);
            $table->foreignIdFor(User::class, 'target_user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
