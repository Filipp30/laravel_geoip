<?php

namespace App\Http\Controllers;

use GeoIp2\WebService\Client;
use Illuminate\Http\Request;

class IpController extends Controller{


    public function run(){


    }

    public function get_location($ip){
        $client = new Client(602468, 'ZDNBj5rMwDkyRToT');
        return $country = $client->country($ip);
    }
}
