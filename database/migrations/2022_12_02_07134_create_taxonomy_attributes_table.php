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
        Schema::create('taxonomy_attributes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("taxonomy_id");
            $table->foreign("taxonomy_id")->references("id")->on("custom_taxonomies")->onDelete("cascade");
            $table->text("attribute_name");
            $table->text("attribute_description")->nullable(true);
            $table->string("attribute_image")->nullable(true);
            $table->string("attribute_slug");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxonomy_attributes');
    }
};
