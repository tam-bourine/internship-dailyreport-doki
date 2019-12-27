<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'name' => "laravel",
            ],
            [
                'name' => 'PHP',
            ],
            [
                'name' => 'HTML',
            ],
            [
                'name' => 'Vue',
            ],
            [
                'name' => 'Nuxt',
            ],
            [
                'name' => 'CSS',
            ],
            [
                'name' => 'Docker',
            ],
            [
                'name' => 'CircleCI',
            ],
            [
                'name' => 'Aws',
            ],
            [
                'name' => 'Typescript',
            ],
        ]);
    }
}
