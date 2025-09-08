<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'sangeeth@uom.lk',
        //     'contact' => '0771234567',
        //     'password' => '1',
        //     'access_level' => 0
        // ]);

        $this->call([
            GalleryItemSeeder::class,
            NewsArticleSeeder::class,
            AnnouncementSeeder::class,
            EventSeeder::class,
            MerchSeeder::class,
        ]);
    }
}
