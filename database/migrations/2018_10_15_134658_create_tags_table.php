<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('class');
            $table->timestamps();
        });

        DB::table('tags')->insert(
            [
                'label' => 'Important',
                'class' => 'important',
                'created_at' => Now(),
                'updated_at' => Now()
            ]
        );
        DB::table('tags')->insert( 
            [
                'label' => 'Completed',
                'class' => 'completed',
                'created_at' => Now(),
                'updated_at' => Now()
            ]
        );
        DB::table('tags')->insert(
            [
                'label' => 'In Progress',
                'class' => 'in_progress',
                'created_at' => Now(),
                'updated_at' => Now()
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
