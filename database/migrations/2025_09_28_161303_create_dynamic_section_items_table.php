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
        Schema::create('dynamic_section_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('dynamic_sections');
            $table->string('title');
            $table->string('year');
            $table->text('description');
            $table->string('link_url')->nullable();
            $table->string('link_text')->nullable();
            $table->integer('sort_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_section_items');
    }
};
