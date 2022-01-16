<?php

namespace App\Http\Controllers\GeoIp2;

use App\ExternalServices\Contracts\GeoLocationContract;
use App\Http\Controllers\Controller;
use App\Models\GeoIp;
use App\Repository\Services\GeoIp\GeoIpRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GeoIp2Controller extends Controller
{

    public function handleIp($ip): bool
    {
        //### Validate ip address, ###
        $ipIsValid = Validator::make(['visitor_ip_address' => $ip], ['visitor_ip_address' => 'required|ip']);
        if ($ipIsValid->fails()) {

            return false;
        }

        //### If visitor IP not existing in the DB and the data is valid then will be saved. ###
        if (!GeoIp::query()->where('visitor_ip_address', '=', $ip)->exists()) {
            $geo_ip_data = app(GeoLocationContract::class)->get_location($ip);
            if ($geo_ip_data) {
                GeoIpRepository::saveGeoDataVisitor($geo_ip_data, $ip);
                return true;
            }

            // ### Ip address is not from private network. ###
            $this->ip_not_valid($ip);

            return false;
        }

        //### If IP existing in the DB then the table:visiting_count will be updated. ###
        GeoIp::query()->where('visitor_ip_address', '=', $ip)
            ->update(['visiting_count' => DB::raw('visiting_count+1')]);

        return true;
    }

    public function ip_not_valid($ip)
    {

    }
}
