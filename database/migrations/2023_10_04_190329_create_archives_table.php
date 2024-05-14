<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->id();

            $table->text('title')->nullable();
            $table->text('name');
            $table->text('path');
            $table->text('extension');
            $table->boolean('highlight');
            $table->text('desc')->nullable();
            $table->text('table')->nullable();
            $table->integer('reference_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('cruds')->insert(['titulo' => 'Archives']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
