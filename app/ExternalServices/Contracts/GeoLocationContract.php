<?php
namespace App\ExternalServices\Contracts;

interface  GeoLocationContract{

    public function get_location($ip);
}
