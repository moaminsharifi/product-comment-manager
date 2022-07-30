<?php

namespace Tests\Feature\API\Comment;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Support\Facades\Bus;
use App\Jobs\IncrementCommentOfProductJob;
class CreateTest extends TestCase
{
    use RefreshDatabase;
    private $jsonStructResponseData = [
        'data'=>[
            'comment',
            'id',
        ],
    ];

    /**
     * user can add one comment to exist product.
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_add_one_comment_to_exist_product()
    {
        // prepare data
        $user = User::factory()->create();
        $product = Product::factory()->create(['creator_id'=>$user->id]);
        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'password',
        ];

        // send request
        $response = $this->json('POST', route('api.login'), $userDataForLogin);
        // after send request assertion
        $response->assertStatus(Response::HTTP_OK);

        $token = json_decode($response->getContent())->data->token;
        $header = [
            'HTTP_Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $commentData = [
            'productName'=>$product->name,
            'comment'=> 'comment',
        ];

        $response = $this->json('POST', route('api.AddNewComment'), $commentData, $header);

        $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(
            $this->jsonStructResponseData
        );
    }

    /**
     * user can add one comment to not exist product.
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_add_one_comment_to_not_exist_product()
    {
        // prepare data
        $user = User::factory()->create();

        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'password',
        ];

        // send request
        $response = $this->json('POST', route('api.login'), $userDataForLogin);
        // after send request assertion
        $response->assertStatus(Response::HTTP_OK);

        $token = json_decode($response->getContent())->data->token;
        $header = [
            'HTTP_Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $commentData = [
            'productName'=>'randomProductName',
            'comment'=> 'comment',
        ];

        $response = $this->json('POST', route('api.AddNewComment'), $commentData, $header);

        $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(
            $this->jsonStructResponseData
        );

        $this->assertDatabaseHas('products', [
            'name'=> $commentData['productName'],
        ]);
    }

    /**
     * user can add two comment to  product.
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_add_two_comment_to_product()
    {
        // prepare data
        $user = User::factory()->create();
        $product = Product::factory()->create(['creator_id'=>$user->id]);
        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'password',
        ];

        // send request
        $response = $this->json('POST', route('api.login'), $userDataForLogin);
        // after send request assertion
        $response->assertStatus(Response::HTTP_OK);

        $token = json_decode($response->getContent())->data->token;
        $header = [
            'HTTP_Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        //  Add Comment 1
        $commentData = [
            'productName'=> $product->name,
            'comment'=> 'comment 1',
        ];

        $response = $this->json('POST', route('api.AddNewComment'), $commentData, $header);

        $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(
            $this->jsonStructResponseData
        );
        //  Add Comment 2
        $commentData = [
            'productName'=> $product->name,
            'comment'=> 'comment 2',
        ];

        $response = $this->json('POST', route('api.AddNewComment'), $commentData, $header);

        $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(
            $this->jsonStructResponseData
        );
    }

    /**
     * user can not add more than two comment to product.
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_not_add_more_than_two_comment_to_product()
    {
        // prepare data
        $user = User::factory()->create();
        $product = Product::factory()->create(['creator_id'=>$user->id]);
        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'password',
        ];

        // send request
        $response = $this->json('POST', route('api.login'), $userDataForLogin);
        // after send request assertion
        $response->assertStatus(Response::HTTP_OK);

        $token = json_decode($response->getContent())->data->token;
        $header = [
            'HTTP_Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        //  Add Comment 1
        $commentData = [
            'productName'=> $product->name,
            'comment'=> 'comment 1',
        ];

        $response = $this->json('POST', route('api.AddNewComment'), $commentData, $header);

        $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(
            $this->jsonStructResponseData
        );
        //  Add Comment 2
        $commentData = [
            'productName'=> $product->name,
            'comment'=> 'comment 2',
        ];

        $response = $this->json('POST', route('api.AddNewComment'), $commentData, $header);

        $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(
            $this->jsonStructResponseData
        );

        //  Can not Add Comment 3
        $commentData = [
            'productName'=> $product->name,
            'comment'=> 'comment 2',
        ];

        $response = $this->json('POST', route('api.AddNewComment'), $commentData, $header);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonStructure(
            [
                'error'=>[
                    'code',
                    'message',
                ],
                'data',
            ]
        );
    }
    /**
     * create new comment fire job test
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function create_new_comment_fire_job()
    {
        Bus::fake();
        // prepare data
        $user = User::factory()->create();
        $product = Product::factory()->create(['creator_id'=>$user->id]);
        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'password',
        ];

        // send request
        $response = $this->json('POST', route('api.login'), $userDataForLogin);
        // after send request assertion
        $response->assertStatus(Response::HTTP_OK);

        $token = json_decode($response->getContent())->data->token;
        $header = [
            'HTTP_Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $commentData = [
            'productName'=>$product->name,
            'comment'=> 'comment',
        ];

        $response = $this->json('POST', route('api.AddNewComment'), $commentData, $header);

        $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(
            $this->jsonStructResponseData
        );
        Bus::assertDispatched(IncrementCommentOfProductJob::class);
    }

}
