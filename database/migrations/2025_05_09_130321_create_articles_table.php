<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('content');
            $table->integer('likes')->default(0);
            $table->enum('status', array_column(Status::cases(), 'value'))->default(Status::DRAFT->value);
            $table->foreignUuid('user_id')->constrained('users');
            $table->timestamps();
        });
        Schema::create('article_likes', function (Blueprint $table){
            $table->id('id');
            $table->foreignUuid('user_id')->constrained('users');
            $table->foreignUuid('article_id')->constrained('articles');
            $table->unique(['user_id', 'article_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_likes');
    }
};
