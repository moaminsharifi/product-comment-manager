<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // - Add this user with factory: (user: parspack, pass: random and safe password)
        $user = User::factory()->create([
        'password'=>Hash::make('RADOM_6004d5f8-d8a6-3e95-9ad2-811663edbecf_PASSWORD'),
        'email'=> 'parspack@parspack.com',
        'name'=>'parspack']);
        $productA = Product::factory()->create(['name'=>'A',
        'creator_id'=>$user->id]);

        // - Add below products by default: A, B, C
        $productB = Product::factory()->create(['name'=>'B',
        'creator_id'=>$user->id]);
        $productC = Product::factory()->create(['name'=>'C',
        'creator_id'=>$user->id]);
      
       

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
