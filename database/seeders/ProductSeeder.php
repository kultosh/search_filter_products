<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $min = 100;
        // $max = 500;
        // DB::table('products')->insert([
        //     'user_id' => User::get('id')->random(2),
        //     'name' => Str::random(15),
        //     'description' => Str::random(15, 20),
        //     'price' => rand ($min*10, $max*10) / 10,
        //     'image' => 'test/image'
        // ]);
        // factory(App\Product::class, 10)->create();
        Product::factory()->count(4)->create();
    }
}
