<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('room_chats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('room_id')
                ->constrained('rooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignUuid('sender_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignUuid('receiver_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->longText('message')->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_chats');
    }
};
