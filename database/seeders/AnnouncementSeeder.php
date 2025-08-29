<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::first();
        
        if (!$adminUser) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $announcements = [
            [
                'title' => 'New Responsibilities Elected',
                'content' => "New responsibilities of the Engineering Faculty Students' Union for the coming year were elected.....</br></br><a href=\"https://www.facebook.com/share/p/15oZd1pLiv/\">Share this post</a></br></br>Engineering Faculty Students' Union,</br>University of Moratuwa",
                'type' => 'general',
                'is_active' => true,
                'is_featured' => true,
                'user_id' => $adminUser->id,
                'expires_at' => now()->addWeeks(2),
            ],
            [
                'title' => 'Sri Lanka University Games 2025',
                'content' => "The Sri Lanka University Games 2025 are now underway, with several more sports scheduled over the coming weeks. Practices are currently being held on the university grounds.</br>We kindly request all those engaged in softball and other recreational sports to keep your activities away from the university grounds during practice hours, so our teams can train without interruption.</br></br>Sports Council,</br>University of Moratuwa",
                'type' => 'general',
                'is_active' => true,
                'is_featured' => false,
                'user_id' => $adminUser->id,
                'expires_at' => now()->addMonth(),
            ],
            [
                'title' => '⭕⭕ Let\'s support the Faculty of Medicine....',
                'content' => 'Authorities, please immediately establish the Moratuwa Medical Faculty Professorial Unit, which has been languishing for a long time!!</br></br><a href="https://www.facebook.com/share/p/1A14vi6tbL/">Share this post</a></br></br>Students Union,</br>University of Moratuwa',
                'type' => 'urgent',
                'is_active' => true,
                'is_featured' => false,
                'user_id' => $adminUser->id,
                'expires_at' => now()->addMonths(6),
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }

        $this->command->info('Announcements seeded successfully!');
    }
}