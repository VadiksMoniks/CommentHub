<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $data;

    public function __construct()
    {
        $this->data = [
            [
                'username' => 'test_user',
                'email' => 'test@mail.com',
                'password' => Hash::make('123'),
                'avatar' => 'base-avatar.jpg'
            ],
            [
                'username' => 'real_user',
                'email' => 'real@mail.com',
                'password' => Hash::make('123'),
                'avatar' => '0a427f8c57082a1d1f0da6538acabf32-avatar.jpg'
            ]
        ];
    }

    public function run(): void
    {
        DB::table('accounts')->insert($this->data);
    }
}
