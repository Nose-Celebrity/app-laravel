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
        Schema::create('likes', function (Blueprint $table) {
            $table->id(); // プライマリーキー
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // products_tableと関連
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // users_tableと関連
            $table->timestamp('created_at')->useCurrent(); // 日時をデフォルトで保存
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
