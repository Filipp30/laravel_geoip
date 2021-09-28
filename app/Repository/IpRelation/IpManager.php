<?php


namespace App\Repository\IpRelation;

use App\Http\Controllers\GeoIp2\GeoIp2Controller;
use App\Models\GeoIp;

abstract class IpManager implements IpRepositoryInterface {

    public $ip;
    public $user_id;

    public function __construct($ip, $user_id){
        $this->ip = $ip;
        $this->user_id = $user_id;
    }

    abstract public function handleRelation();

    public function ipExists(): bool{
        return GeoIp::where('visitor_ip_address','=',$this->ip)->exists();
    }

    public function relationExists(): bool{
        return GeoIp::where('visitor_ip_address','=',$this->ip)
        ->whereNotNull('user_id')->exists();
    }

    public function createRelation(){
        GeoIp::where('visitor_ip_address','=',$this->ip)->update(['user_id'=>$this->user_id]);
    }

    public function createVisitor(){
        $geoIp2Controller = new GeoIp2Controller();
        $geoIp2Controller->handleIp($this->ip);
    }
}
