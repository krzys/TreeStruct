<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreeStructTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tree_struct', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('parent')->nullable();
            $table->unsignedInteger('display_order')->default(1);
        });

        \Illuminate\Support\Facades\DB::unprepared('' .
        'DELIMITER ;;
        CREATE PROCEDURE `change_tree_struct_element_order` (IN idx int, IN ord int)
        BEGIN
            SET @parent = (SELECT parent FROM tree_struct WHERE id = idx);
            SET @row = 0;
            UPDATE tree_struct as `a` SET display_order = (SELECT r FROM (SELECT (@row:=@row+1) as r, id FROM tree_struct WHERE ((@parent is null and parent is null) OR parent = @parent) ORDER BY display_order) as `b` WHERE b.id = a.id) WHERE ((@parent is null and parent is null) OR parent = @parent);
            SET @prevValue = (SELECT display_order FROM tree_struct WHERE id = idx);
            UPDATE tree_struct SET display_order = ord WHERE id = idx;

            SET @duplicatedId = (SELECT id FROM tree_struct WHERE display_order = ord AND id != idx AND ((@parent is null and parent is null) OR parent = @parent) LIMIT 1);
            UPDATE tree_struct SET display_order = @prevValue WHERE id = @duplicatedId;
        END;;
        DELIMITER ;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tree_struct');
        \Illuminate\Support\Facades\DB::unprepared('DROP PROCEDURE IF EXISTS `change_tree_struct_element_order`;');
    }
}
