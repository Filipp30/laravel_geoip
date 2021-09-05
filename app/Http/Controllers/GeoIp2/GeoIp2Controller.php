<?php

namespace App\Http\Controllers\GeoIp2;

use App\Http\Controllers\Controller;
use GeoIp2\WebService\Client;


class GeoIp2Controller extends Controller
{
    /**
     * @throws \GeoIp2\Exception\GeoIp2Exception
     * @throws \GeoIp2\Exception\HttpException
     * @throws \GeoIp2\Exception\OutOfQueriesException
     * @throws \GeoIp2\Exception\AddressNotFoundException
     * @throws \GeoIp2\Exception\AuthenticationException
     * @throws \GeoIp2\Exception\InvalidRequestException
     */
    public function get_location($ip): array
    {
        $client = new Client(602468, 'iaRImnahWwvDxuYn', ['en'], ['host' => 'geolite.info']);
        $country = $client->country($ip);
        return [
            'continent'=>[
                'id'=>$country->continent->geonameId,
                'iso_code'=>$country->continent->code,
                'name'=>$country->continent->names['en']
            ],
            'country'=>[
                'id'=>$country->country->geonameId,
                'iso_code'=>$country->country->isoCode,
                'is_in_european_union'=>$country->country->isInEuropeanUnion,
                'name'=>$country->country->names['en']
            ],
            'traits'=>$country->traits
        ];
    }
}
