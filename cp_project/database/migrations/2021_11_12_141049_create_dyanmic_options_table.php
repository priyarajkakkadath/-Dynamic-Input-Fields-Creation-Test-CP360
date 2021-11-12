<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\DynamicOptions;
class CreateDyanmicOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new DynamicOptions())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->integer('input_id')->comment("form_input_fields  primary key");
            $table->string('label',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new DynamicOptions())->getTable());
    }
}
