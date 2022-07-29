<?php

namespace Tests\Feature\API\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\User;

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

    /**
     * user can not sing up with bad email test
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_not_sing_up_with_bad_email()
    {
        // 1 - check with out email
        // prepare data
        $userDataForRegister = [
            'name' => 'laravel',
            'password'=>'password',
            'password_confirm'=>'password',
        ];
        // before send assertion
        $this->assertDatabaseCount('users', 0);

        // send request
        $response = $this->json('POST', route('api.signup'), $userDataForRegister);
        // after send request assertion
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        // 2 - check with  bad email
        $userDataForRegister['email'] = 'google.com';
        // send request
        $response = $this->json('POST', route('api.signup'), $userDataForRegister);
        // after send request assertion
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // 3 - check with  exist email
        $user = User::factory()->create();
        $userDataForRegister['email'] = $user->email;
        // send request
        $response = $this->json('POST', route('api.signup'), $userDataForRegister);
        // after send request assertion
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }


     /**
     * user can not sing up with bad name test
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_not_sing_up_with_bad_name()
    {
        // 1 - check with out name
        // prepare data
        $userDataForRegister = [
            'email'=>'test@local.com',
            'password'=>'password',
            'password_confirm'=>'password',
        ];
        // before send assertion
        $this->assertDatabaseCount('users', 0);

        // send request
        $response = $this->json('POST', route('api.signup'), $userDataForRegister);
        // after send request assertion
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        // 2 - check with  bad name
        $userDataForRegister['name'] = '';
        // send request
        $response = $this->json('POST', route('api.signup'), $userDataForRegister);
        // after send request assertion
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * user can not sing up with bad password test
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_not_sing_up_with_bad_password()
    {
        // 1 - check with out password
        // prepare data
        $userDataForRegister = [
            'email'=>'test@local.com',
            'name'=>'laravel',
            'password_confirm'=>'password',
        ];
        // before send assertion
        $this->assertDatabaseCount('users', 0);

        // send request
        $response = $this->json('POST', route('api.signup'), $userDataForRegister);
        // after send request assertion
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        // 2 - check with  bad password
        $userDataForRegister['name'] = '';
        // send request
        $response = $this->json('POST', route('api.signup'), $userDataForRegister);
        // after send request assertion
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        // 3 - check with  password_confirm miss math password password
        $userDataForRegister = [
            'email'=>'test@local.com',
            'name' => 'laravel',
            'password'=>'password',
            'password_confirm'=>'PASSWORD_NOT_SAME',
        ];
        // send request
        $response = $this->json('POST', route('api.signup'), $userDataForRegister);
        // after send request assertion
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }



}
