<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoIpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_ip', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('visitor_ip_address')->unique();
            $table->char('autonomous_network')->nullable(true);
            $table->integer('user_id')->nullable(true);
            $table->integer('visiting_count');
            $table->timestamps();
            $table->integer('continent_geo_id')->nullable(true);
            $table->string('continent_iso_code')->nullable(true);
            $table->string('continent_iso_name')->nullable(true);
            $table->integer('country_geo_id')->nullable(true);
            $table->string('country_iso_code')->nullable(true);
            $table->string('country_iso_name')->nullable(true);
            $table->boolean('country_is_in_european_union')->nullable(true);
            $table->integer('city_geo_id')->nullable(true);
            $table->string('city_geo_name')->nullable(true);
            $table->integer('postal_code')->nullable(true);
            $table->string('province')->nullable(true);
            $table->integer('accuracy_radius')->nullable(true);
            $table->char('latitude')->nullable(true);
            $table->char('longitude')->nullable(true);
            $table->string('time_zone')->nullable(true);
            $table->integer('autonomous_system_number')->nullable(true);
            $table->string('autonomous_system_organization')->nullable(true);
            $table->boolean('is_hosting_provider')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geo_ip');
    }
}
