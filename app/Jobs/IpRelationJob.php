<?php

namespace App\Jobs;

use App\Repository\Services\IpRelation\IpRelationHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IpRelationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $ip;
    protected $ipRelationHandler;

    public function __construct($id,$ip)
    {
        $this->id = $id;
        $this->ip = $ip;
        $this->ipRelationHandler = new IpRelationHandler($this->ip,$this->id);
    }

    public function handle(){
        $this->ipRelationHandler->handleRelation();
    }
}
