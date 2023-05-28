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
        Schema::create('artwork_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('artwork_id');
            $table->unsignedBigInteger('artist_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('price', 8, 2);
            $table->unsignedBigInteger('status_id')->default(1);
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();

            $table->foreign('purchase_id')->references('id')->on('artwork_purchases')->onDelete('cascade');
            $table->foreign('artwork_id')->references('id')->on('artworks')->onDelete('cascade');
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artwork_purchase_details');
    }
};
