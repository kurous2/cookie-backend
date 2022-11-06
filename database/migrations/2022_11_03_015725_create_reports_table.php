<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('category');
            $table->string('location')->nullable();
            $table->string('target_donation')->nullable();
            $table->enum('status',['initial','onprogress','ondonation','completed'])->default('initial');
            $table->string('due_date')->nullable();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('community_id')->nullable()->constrained('communities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('pic_name')->nullable();
            $table->string('docs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
