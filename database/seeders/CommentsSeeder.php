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
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'second comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => '<strong><i>enjoy!</i></strong>',
                'username' => 'test_user',
                'document' => null,
                'image' => 'media/a4715f-source.gif',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'Hello',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'wazzap',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'text',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'also text',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'more text',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'and some more text',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => '<strong>Follow</strong> me on my<a href="https://youtube.com"><code>Youtube chanel!</code></a>',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'another comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'also comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => '<i>comment-2000</i>',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',
                'username' => 'real_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'not second comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'again comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
                        [
                'text' => 'comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'real',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'text' => 'comment',
                'username' => 'test_user',
                'document' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];
    }

    public function run(): void
    {
        DB::table('comments')->insert($this->data);
    }
}
