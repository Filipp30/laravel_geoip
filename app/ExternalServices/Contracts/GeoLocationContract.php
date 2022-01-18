<?php
namespace App\ExternalServices\Contracts;

interface  GeoLocationContract{

    public function getLocation($ip);
}
