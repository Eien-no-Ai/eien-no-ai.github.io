<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('artists', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('bio')->nullable();
        $table->string('featured_artwork_image_url')->nullable();
        $table->timestamps();
    });

    Schema::table('artworks', function (Blueprint $table) {
        $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
