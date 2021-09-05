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
        $city = $client->city($ip);
        return [
            'continent'=>[
                'geo_id'=>$country->continent->geonameId,
                'iso_code'=>$country->continent->code,
                'name'=>$country->continent->names['en']
            ],
            'country'=>[
                'geo_id'=>$country->country->geonameId,
                'iso_code'=>$country->country->isoCode,
                'is_in_european_union'=>$country->country->isInEuropeanUnion,
                'name'=>$country->country->names['en']
            ],
            'city'=>[
                'geo_id'=>$city->city->geonameId,
                'name'=>$city->city->names['en'],
                'postal_code'=>$city->postal->code,
                'province'=>$city->subdivisions[0]->names['en'],
                'location'=>$city->location,
            ],
            'internet_provider'=>$city->traits,
        ];
    }
}
