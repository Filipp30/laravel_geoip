<?php

namespace App\Http\Controllers\GeoIp2;

use App\Http\Controllers\Controller;
use App\Models\GeoIp;
use App\Services\Contracts\GeoLocationContract;
use Illuminate\Support\Facades\DB;

class GeoIp2Controller extends Controller{

    public function handleIp($ip){

        //### If visitor IP not existing in the DB and the data is valid then will be saved. ###
        if (!GeoIp::query()->where('visitor_ip_address','=',$ip)->exists()){

            $geo_ip_data = app(GeoLocationContract::class)->get_location($ip);

            if ($geo_ip_data){ $this->saveGeoDataVisitor($geo_ip_data,$ip); return;}

            // ### Ip address is not from private network. ###
            $this->ip_not_valid($ip);
            return;
        }

        //### If IP existing in the DB then the table:visiting_count will be updated. ###
        GeoIp::where('visitor_ip_address','=',$ip)
        ->update(['visiting_count'=>DB::raw('visiting_count+1')]);
    }


    public function saveGeoDataVisitor($data,$ip){
        GeoIp::create([
            'visitor_ip_address'=>$ip,
            'visiting_count'=>1,
            'continent_geo_id'=>$data['continent']['geo_id'],
            'continent_iso_code'=>$data['continent']['iso_code'],
            'continent_iso_name'=>$data['continent']['name'],
            'country_geo_id'=>$data['country']['geo_id'],
            'country_iso_code'=>$data['country']['iso_code'],
            'country_iso_name'=>$data['country']['name'],
            'country_is_in_european_union'=>$data['country']['is_in_european_union'],
            'city_geo_id'=>$data['city']['geo_id'],
            'city_geo_name'=>$data['city']['name'],
            'postal_code'=>$data['city']['postal_code'],
            'province'=>$data['city']['province'],
            'accuracy_radius'=>$data['accuracy_radius'],
            'latitude'=>$data['latitude'],
            'longitude'=>$data['longitude'],
            'time_zone'=>$data['time_zone'],
            'autonomous_system_number'=>$data['autonomous_system_number'],
            'autonomous_system_organization'=>$data['autonomous_system_organization'],
            'autonomous_network'=>$data['autonomous_network'],
            'is_hosting_provider'=>$data['is_hosting_provider']
        ]);
    }

    public function ip_not_valid($ip){

    }
}
