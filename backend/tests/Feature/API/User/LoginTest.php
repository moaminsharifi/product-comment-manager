<?php

namespace Tests\Feature\API\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\User;
class LoginTest extends TestCase
{
    use RefreshDatabase;
   
    private $jsonStructUserData =  [
        'data'=>[
            'token',
            'token_type',
            'name',
            'email',
            'id'
        ]
    ];
    
    /**
     * user can login
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_login(){
        // prepare data
        $user = User::factory()->create();
        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'password',
        ];
        // before send assertion
        $this->assertDatabaseCount('users',1);

        // send request
        $response = $this->json('POST' , route('api.login'), $userDataForLogin);
        // after send request assertion
        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            $this->jsonStructUserData
        );
        $this->assertDatabaseCount('users',1);
        $this->assertDatabaseHas('users',[
            'email'=>$userDataForLogin['email']
        ]);
    }


}