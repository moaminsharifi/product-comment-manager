<?php

namespace Tests\Feature\API\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
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
     * user can login.
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_login()
    {
        // prepare data
        $user = User::factory()->create();
        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'password',
        ];
        // before send assertion
        $this->assertDatabaseCount('users', 1);

        // send request
        $response = $this->json('POST', route('api.login'), $userDataForLogin);
        // after send request assertion
        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            $this->jsonStructUserData
        );
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email'=>$userDataForLogin['email'],
        ]);
    }

    /**
     * user can not login with bad email test.
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_not_login_with_bad_email()
    {
        // prepare data
        $user = User::factory()->create();
        $userDataForLogin = [
            'email'=>  'NOTVALID@local.com',
            'password'=>'password',
        ];
        // before send assertion
        $this->assertDatabaseCount('users', 1);

        // send request
        $response = $this->json('POST', route('api.login'), $userDataForLogin);

        // after send request assertion
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * user can not login with bad password test.
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_not_login_with_bad_password()
    {
        $user = User::factory()->create();
        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'NOT_VALID_password',
        ];
        // before send assertion
        $this->assertDatabaseCount('users', 1);

        // send request
        $response = $this->json('POST', route('api.login'), $userDataForLogin);

        // after send request assertion
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
