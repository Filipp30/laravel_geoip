<?php

namespace Tests\Feature;

use App\Models\GeoIp;
use App\Models\User;
use App\Repository\Services\IpRelation\IpRelationHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

     public function test_user_registration(){
         $response = $this->post('/api/auth/registration',[
             'name' => 'Test User',
             'email' => 'test@example.com',
             'phone_number' => '+32456789123',
             'password' => '12345678',
             'password_confirmation' => '12345678',
         ]);
         $response->assertStatus(200);
     }

     public function test_relate_ip_address_to_user( ){

         $responseIp = $this->get('/api/ip/run/81.11.139.169');
         $responseIp->assertStatus(200);

         $responseRegistration = $this->withHeaders([
             'Accepts' => 'application/json',
             'X-Real-Ip' => '81.11.139.169'
         ])->post('/api/auth/registration',[
             'name' => 'Test User',
             'email' => 'test@example.com',
             'phone_number' => '+32456789123',
             'password' => '12345678',
             'password_confirmation' => '12345678',
         ]);
         $responseRegistration->assertStatus(200);

         $userId = User::query()->select(['id'])->where('email','=','test@example.com')->get();
         $ipRelationHandler = new IpRelationHandler('81.11.139.169',$userId[0]['id']);
         $ipRelationHandler->handleRelation();
         $geoIpRelationId = GeoIp::query()->where('visitor_ip_address','=','81.11.139.169')->get();

         $this->assertTrue($userId[0]['id'] == $geoIpRelationId[0]['user_id']);
     }
}
