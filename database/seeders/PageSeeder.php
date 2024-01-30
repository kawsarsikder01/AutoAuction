<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use Carbon\Carbon;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $pages = [
            ['name' => 'forget password', 'slug' => 'forget-password', 'template_name' => 'light', 'type' => 1],
            ['name' => 'verification code', 'slug' => 'verification-code', 'template_name' => 'light', 'type' => 1]
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['name' => $page['name']],
                [
                    'slug' => $page['slug'],
                    'template_name' => $page['template_name'],
                    'type' => $page['type'],
                ],
                [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
