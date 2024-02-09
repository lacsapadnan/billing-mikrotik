<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            'Announcement',
            'Order_Voucher',
            'Privacy_Policy',
            'Registration_Info',
            'Terms_and_Conditions',
            'Voucher',
        ];
        foreach ($pages as $title) {
            $content = file_get_contents(database_path("seeders/raw/html/$title.html"));
            \App\Models\Page::create([
                'title' => $title,
                'content' => $content,
            ]);
        }
    }
}
