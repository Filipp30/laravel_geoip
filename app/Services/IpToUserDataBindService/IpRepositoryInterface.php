<?php


namespace App\Services\IpToUserDataBindService;

interface IpRepositoryInterface{

    /**
     * Determine if a ip address record exists in to database.
     *
     * @return boolean
     */
    public function ipExists(): bool;


    /**
     * Determine if the ip already has a relationship with the user_id.
     *
     * @return boolean
     */
    public function relationExists(): bool;


    /**
     * Create relation between user_id and ip-address.
     * Update table geo_ip --> user_id
     *
     */
    public function createRelation();


    /**
     * Create a new visitor in to database.
     *
     */
    public function createVisitor();

}
