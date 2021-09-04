<?php

namespace App\Http\Controllers;

use GeoIp2\WebService\Client;
use Illuminate\Http\Request;

class IpController extends Controller{


    public function run(){


    }

    /**
     * @throws \GeoIp2\Exception\GeoIp2Exception
     * @throws \GeoIp2\Exception\HttpException
     * @throws \GeoIp2\Exception\OutOfQueriesException
     * @throws \GeoIp2\Exception\AddressNotFoundException
     * @throws \GeoIp2\Exception\AuthenticationException
     * @throws \GeoIp2\Exception\InvalidRequestException
     */
    public function get_location($ip){
        $client = new Client(602468, 'iaRImnahWwvDxuYn', ['en'], ['host' => 'geolite.info']);

        return [
            'country'=> $client->country($ip),
            'city'=> $client->city($ip),
//            'insights'=> $client->insights($ip)
        ];

    }
}
