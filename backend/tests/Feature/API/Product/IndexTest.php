<?php

namespace Tests\Feature\API\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Response;
class IndexTest extends TestCase
{
    use RefreshDatabase;
    private $jsonStructResponseData =  [
        'data'=>[
            '*' =>[
                'id',
                'name',
                'comments'
            ]
        ]
    ];

    /**
     * user can get all product list
     * @test
     * @group API
     * @group User
     * @group Feature
     * @return void
     */
    public function user_can_get_all_product_list(){
        // prepare data
        $user = User::factory()->create();
        $product = Product::factory()->create(['creator_id'=>$user->id]);
        Comment::factory(5)->create()->each(function($comment) use ($product, $user){
            $product->comments()->attach($comment->id);
            $user->comments()->attach($comment->id);
        });
        $userDataForLogin = [
            'email'=>  $user->email,
            'password'=>'password',
        ];
 

        // send request
        $response = $this->json('POST' , route('api.login'), $userDataForLogin);
        // after send request assertion
        $response->assertStatus(Response::HTTP_OK);

        $token = json_decode($response->getContent())->data->token;
        $header = [
            'HTTP_Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

    

        $response = $this->json('GET',route('api.getAllProducts'),[], $header);
   
        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            $this->jsonStructResponseData
     );
    }
}
