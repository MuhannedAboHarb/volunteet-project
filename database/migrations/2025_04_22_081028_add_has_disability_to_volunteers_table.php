<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->boolean('has_disability')->nullable()->after('address');
        });
    }
    
    public function down()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn('has_disability');
        });
    }
    
};
