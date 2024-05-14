<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('redes-sociais', function (Blueprint $table) {
            $table->id();

            $table->text('nome');
            $table->text('icone');
            $table->text('link')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('cruds')->insert(['titulo' => 'Redes Sociais']);

        DB::table('redes-sociais')->insert([
            'nome' => 'Linkedin',
            'icone' => 'fa fa-linkedin',
            'link' => 'https://www.linkedin.com/in/lucas-soares-pb1/',
        ]);

        DB::table('redes-sociais')->insert([
            'nome' => 'Instagram',
            'icone' => 'fa fa-instagram',
            'link' => 'https://www.instagram.com/__lucasoares_/',
        ]);
        
        DB::table('redes-sociais')->insert([
            'nome' => 'Github',
            'icone' => 'fa fa-github',
            'link' => 'https://github.com/Lucas-PB1',
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redes-sociais');
    }
};