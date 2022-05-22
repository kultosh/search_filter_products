<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => Str::random(4),
        //     'email' => Str::random(4).'@gmail.com',
        //     'password' => Hash::make('password'),
        // ]);
        User::factory()->has(Product::factory()->count(5))->count(3)->create();
    }
}
