<?php

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
        Schema::create('replies', function (Blueprint $table) {
            $table->id(); // ID: auto increment
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');     // userID: リレーション
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // productID: リレーション
            $table->char('title');  // title: Char
            $table->char('body');     //
            $table->date('date');     // date: date
            $table->timestamps();     // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
