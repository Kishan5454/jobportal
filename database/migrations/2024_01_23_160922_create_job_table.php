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
        Schema::create('job', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('catagory_id');            
            $table->foreign('catagory_id')->references('catagory_id')->on('catagories')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('jobtype_id');
            $table->foreign('jobtype_id')->references('jobtype_id')->on('jobtype')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('vacancy');
            $table->string('salary')->nullable();
            $table->string('location');
            $table->text('description')->nullable();
            $table->text('benifits')->nullable();
            $table->text('responsibility')->nullable();
            $table->text('qualification')->nullable();
            $table->text('keyword')->nullable();
            $table->string('experience');
            $table->string('comapny_name');
            $table->string('comapny_location')->nullable();
            $table->string('comapny_website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job');
    }
};