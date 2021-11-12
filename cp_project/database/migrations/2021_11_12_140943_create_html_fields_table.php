<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\HTMLFields;

class CreateHtmlFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new HTMLFields())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('type',100)->comment("like text,number,dropdown");
            $table->enum('multiple_options', ['0', '1'])->comment("0-no oprions, 1-have options like for dropdown");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new HTMLFields())->getTable());
    }
}
