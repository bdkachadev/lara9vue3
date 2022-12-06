<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_taxonomies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text("taxonomy_name");
            $table->text("taxonomy_description")->nullable(true);
            $table->string("taxonomy_image")->nullable(true);
            $table->string("taxonomy_slug");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_taxonomies');
    }
};
