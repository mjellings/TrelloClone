<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardUserTableAndMigrateData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_user', function (Blueprint $table) {
            $table->integer('board_id')->unsigned()->index();
            $table->foreign('board_id')->references('id')->on('boards');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_owner')->default(false);
            $table->boolean('can_write')->default(false);
            $table->timestamps();
        });

        $results = DB::table('boards')->select(['id', 'user_id', 'created_at', 'updated_at'])->get();

        foreach($results as $result) {
            DB::table('board_user')->insert([
                "board_id"    =>  $result->id,
                "user_id"  =>  $result->user_id,
                'is_owner' => true,
                'can_write' => true,
                'created_at' => $result->created_at,
                'updated_at' => $result->updated_at
            ]);
        }

        Schema::table('boards', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropColumn('user_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->after('id');;
        });

        Schema::dropIfExists('board_user');
    }
}
