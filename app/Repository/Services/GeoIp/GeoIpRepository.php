<?php

namespace App\Repository\Services\GeoIp;

use App\Models\GeoIp;
use Illuminate\Support\Facades\DB;

class GeoIpRepository
{

    static public function saveGeoDataVisitor($data, $ip)
    {
        GeoIp::create([
            'visitor_ip_address' => $ip,
            'visiting_count' => 1,
            'continent_geo_id' => $data['continent']['geo_id'],
            'continent_iso_code' => $data['continent']['iso_code'],
            'continent_iso_name' => $data['continent']['name'],
            'country_geo_id' => $data['country']['geo_id'],
            'country_iso_code' => $data['country']['iso_code'],
            'country_iso_name' => $data['country']['name'],
            'country_is_in_european_union' => $data['country']['is_in_european_union'],
            'city_geo_id' => $data['city']['geo_id'],
            'city_geo_name' => $data['city']['name'],
            'postal_code' => $data['city']['postal_code'],
            'province' => $data['city']['province'],
            'accuracy_radius' => $data['accuracy_radius'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'time_zone' => $data['time_zone'],
            'autonomous_system_number' => $data['autonomous_system_number'],
            'autonomous_system_organization' => $data['autonomous_system_organization'],
            'autonomous_network' => $data['autonomous_network'],
            'is_hosting_provider' => $data['is_hosting_provider'],
        ]);
    }

    static public function visitorIpAddressExists($ip): bool
    {
        return GeoIp::query()->where('visitor_ip_address', '=', $ip)->exists();
    }

    static public function incrementVisitingCount($ip)
    {
        GeoIp::query()->where('visitor_ip_address', '=', $ip)
            ->update(['visiting_count' => DB::raw('visiting_count+1')]);
    }
}
