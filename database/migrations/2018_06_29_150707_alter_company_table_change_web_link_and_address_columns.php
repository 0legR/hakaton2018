<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompanyTableChangeWebLinkAndAddressColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('web_link')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->renameColumn('created_by', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('user_id', 'created_by');
            $table->string('address')->change();
            $table->string('web_link')->change();
        });
    }
}
