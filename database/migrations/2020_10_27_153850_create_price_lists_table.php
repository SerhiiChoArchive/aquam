<?php

use App\ConversionResult;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->mediumText(ConversionResult::FISH);
            $table->mediumText(ConversionResult::EQUIPMENT);
            $table->mediumText(ConversionResult::FEED);
            $table->mediumText(ConversionResult::CHEMISTRY);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_lists');
    }
}
