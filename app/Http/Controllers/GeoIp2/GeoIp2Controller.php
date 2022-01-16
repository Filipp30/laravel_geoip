<?php

namespace App\Http\Controllers\GeoIp2;

use App\ExternalServices\Contracts\GeoLocationContract;
use App\Http\Controllers\Controller;
use App\Repository\Services\GeoIp\GeoIpRepository;
use Illuminate\Support\Facades\Validator;

class GeoIp2Controller extends Controller
{

    public function handleIp($ip): bool
    {
        //### Validate ip address, ###
        Validator::make(['visitor_ip_address' => $ip], ['visitor_ip_address' => 'required|ip']);

        //### If visitor IP not existing in the DB and the data is valid then will be saved. ###
        if (!GeoIpRepository::visitorIpAddressExists($ip)) {
            $geo_ip_data = app(GeoLocationContract::class)->get_location($ip);
            if ($geo_ip_data) {
                GeoIpRepository::saveGeoDataVisitor($geo_ip_data, $ip);
                return true;
            }

            // ### Ip address is not from private network. ###
            return false;
        }

        //### If IP existing in the DB then the table:visiting_count will be updated. ###
        GeoIpRepository::incrementVisitingCount($ip);
        return true;
    }
}
