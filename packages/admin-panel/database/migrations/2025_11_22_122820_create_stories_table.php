<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration
{
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image_url');
            $table->string('link_url')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('order')->default(0);
            $table->integer('view_count')->default(0);
            $table->enum('status', ['active', 'expired', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('status');
            $table->index('expires_at');
            $table->index('order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stories');
    }
}
