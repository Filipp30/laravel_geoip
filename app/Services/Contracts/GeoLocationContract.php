<?php


namespace App\Services\Contracts;


interface  GeoLocationContract{

    public function get_location($ip);

}
