<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::first();
        
        if (!$adminUser) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $events = [
            [
                'title' => 'සොයුරු සත්කාර',
                'description' => 'A cultural event celebrating traditional Sri Lankan hospitality and community spirit.',
                'type' => 'cultural',
                'location' => 'University of Moratuwa',
                'image_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
                'start_datetime' => now()->addDays(30),
                'end_datetime' => now()->addDays(30)->addHours(6),
                'requires_registration' => false,
                'max_participants' => null,
                'facebook_page_url' => 'https://www.facebook.com/share/1YwNzZXVZV/?mibextid=wwXIfr',
                'facebook_album_urls' => [
                    'https://www.facebook.com/share/1JmDMGDspX/?mibextid=wwXIfr'
                ],
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'මැවිසුරු රගසොබා',
                'description' => 'An annual cultural performance showcasing traditional Sri Lankan arts, music, and dance.',
                'type' => 'cultural',
                'location' => 'University of Moratuwa',
                'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
                'start_datetime' => now()->addDays(45),
                'end_datetime' => now()->addDays(45)->addHours(8),
                'requires_registration' => true,
                'max_participants' => 500,
                'facebook_page_url' => null,
                'facebook_album_urls' => [
                    'https://www.facebook.com/share/1BdbQNq4KR/?',
                    'https://www.facebook.com/share/19U5ns5xNx/?',
                    'https://www.facebook.com/share/16oV77BxNq/?mibextid=wwXIfr',
                    'https://www.facebook.com/share/1C6b1Fmpr6/?mibextid=wwXIfr',
                    'https://www.facebook.com/share/1FsGHZK7Wb/?mibextid=wwXIfr'
                ],
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'දේදුනු ගංතොට',
                'description' => 'A community gathering event focusing on environmental awareness and sustainable practices.',
                'type' => 'community',
                'location' => 'University of Moratuwa',
                'image_url' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
                'start_datetime' => now()->addDays(60),
                'end_datetime' => now()->addDays(60)->addHours(4),
                'requires_registration' => false,
                'max_participants' => null,
                'facebook_page_url' => null,
                'facebook_album_urls' => [
                    'https://www.facebook.com/share/1786nUGAkn/?mibextid=wwXIfr'
                ],
                'user_id' => $adminUser->id,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }

        $this->command->info('Events seeded successfully!');
    }
}