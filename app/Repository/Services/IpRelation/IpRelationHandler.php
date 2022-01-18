<?php


namespace App\Repository\Services\IpRelation;


use JetBrains\PhpStorm\Pure;

class IpRelationHandler extends IpManager
{

    #[Pure] public function __construct($ip, $user_id)
    {
        parent::__construct($ip, $user_id);
    }

    function handleRelation()
    {
        if ($this->ipExists() && !$this->relationExists()) {
            $this->createRelation();
            return;
        }

        if (!$this->ipExists()) {
            $this->createVisitor();
            $this->createRelation();
        }
    }
}
