<?php

namespace Tests\Feature\API\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\User;

class GetDataTest extends TestCase
{
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
     * user can get own data test
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_get_own_data(){
        // prepare data
        $user = User::factory()->create();
        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'password',
        ];
 

        // send request
        $response = $this->json('POST' , route('api.login'), $userDataForLogin);
        // after send request assertion
        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            $this->jsonStructUserData
        );

        $token = json_decode($response->getContent())->data->token;
        $header = [
            'HTTP_Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $response = $this->json('GET',route('api.userData'), [], $header);

        // after send request assertion
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                $this->jsonStructUserData
        );

    }


    /**
     * forbid not valid token test
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function forbid_not_valid_token(){
        // prepare data
        $user = User::factory()->create();
        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'password',
        ];
 

        // send request
        $response = $this->json('POST' , route('api.login'), $userDataForLogin);
        // after send request assertion
        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            $this->jsonStructUserData
        );

        $token = 'NOT_VALID_TOKEN';
        $header = [
            'HTTP_Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $response = $this->json('GET',route('api.userData'), [], $header);

        // after send request assertion
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    }
}
