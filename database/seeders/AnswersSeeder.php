<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('answers')->insert([
            [
                'comment_id' => '15',
                'answer_comment_id' => '1'
            ],
            [
                'comment_id' => '27',
                'answer_comment_id' => '15'
            ]
        ]);
    }
}
