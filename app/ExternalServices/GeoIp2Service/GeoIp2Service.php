<?php


namespace App\ExternalServices\GeoIp2Service;

use App\ExternalServices\Contracts\GeoLocationContract;
use GeoIp2\WebService\Client;
use Throwable;

class GeoIp2Service implements GeoLocationContract {

    public function get_location($ip): bool|array
    {
        try {
            $client = new Client(config('services.geo_ip_2.accountId'), config('services.geo_ip_2.licenseKey'), ['en'], ['host' => 'geolite.info']);
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

                    ],
                'accuracy_radius'=>$city->location->accuracyRadius,
                'latitude'=>$city->location->latitude,
                'longitude'=>$city->location->longitude,
                'time_zone'=>$city->location->timeZone,
                'autonomous_system_number'=>$city->traits->autonomousSystemNumber,
                'autonomous_system_organization'=>$city->traits->autonomousSystemOrganization,
                'autonomous_network'=>$city->traits->network,
                'is_hosting_provider'=>$city->traits->isHostingProvider
            ];
        }catch (Throwable $exception){
            return false;
        }
    }
}
