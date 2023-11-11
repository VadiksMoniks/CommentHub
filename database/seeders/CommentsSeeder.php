<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private $data;

    public function __construct()
    {
        $this->data = [
            [
                'text' => 'first comment',
                'username' => 'test_user',
                'created_at' => date('Y-m-d H:i:s'),
                'answer_to' => null
            ],
            [
                'text' => 'second comment',
                'username' => 'test_uset',
                'created_at' => date('Y-m-d H:i:s'),
                'answer_to' => null
            ]
        ];
    }

    public function run(): void
    {
        DB::table('comments')->insert($this->data);
    }
}
