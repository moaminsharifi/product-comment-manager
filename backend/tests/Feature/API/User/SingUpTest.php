<?php

namespace Tests\Feature\API\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class SingUpTest extends TestCase
{
    use RefreshDatabase;
    private $jsonStructUserData = [
        'data'=>[
            'token',
            'token_type',
            'name',
            'email',
            'id',
        ],
    ];

    /**
     * user can sing up.
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_sing_up()
    {
        // prepare data
        $userDataForRegister = [
            'email'=>'test@local.com',
            'name' => 'laravel',
            'password'=>'password',
            'password_confirm'=>'password',
        ];
        // before send assertion
        $this->assertDatabaseCount('users', 0);

        // send request
        $response = $this->json('POST', route('api.signup'), $userDataForRegister);
        // after send request assertion
        $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(
            $this->jsonStructUserData
        );
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email'=>$userDataForRegister['email'],
        ]);
    }
}
