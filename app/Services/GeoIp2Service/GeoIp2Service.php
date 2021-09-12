<?php


namespace App\Services\GeoIp2Service;

use App\Services\Contracts\GeoLocationContract;
use GeoIp2\WebService\Client;
use Throwable;

class GeoIp2Service implements GeoLocationContract {

    public function get_location($ip): array
    {
        try {
            $client = new Client(config('geo_ip_2.accountId'), config('geo_ip_2.licenseKey'), ['en'], ['host' => 'geolite.info']);
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
        }catch (Throwable $exception){
            return [
                'error'=>$exception
            ];
        }
    }
}
