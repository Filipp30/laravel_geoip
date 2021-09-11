<?php

namespace App\Http\Controllers\GeoIp2;

use App\Http\Controllers\Controller;
use GeoIp2\WebService\Client;
use Illuminate\Support\Facades\Mail;
use Throwable;


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
        try {
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
        }catch (Throwable $exception){
            return [
              'error'=>$exception
            ];
        }
    }

    public function send_to_admin($data){
        $subject = "ip_data notification on : ";
        $file_name = 'log_time_'.time().'.txt';
        $log_file = fopen($file_name,'w');
        fwrite($log_file, json_encode($data));
        fclose($log_file);

        Mail::send('./email_templates/notification',$data,function($message) use ($file_name, $subject){
            $message->attach($file_name);
            $message->to('filipp-tts@outlook.com');
            $message->subject($subject);
        });
        unlink('./'.$file_name);
    }
}
