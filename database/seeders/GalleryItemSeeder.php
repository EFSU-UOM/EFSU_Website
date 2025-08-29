<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GalleryItemSeeder extends Seeder
{
    public function run(): void
    {
        $galleryItems = [
            [
                'title' => 'මැවිසුරු රඟසොබා - 2025',
                'description' => 'Album 1',
                'type' => 'image',
                'file_path' => 'https://i.ibb.co/mrfZ1BLQ/539928303-1284745606774763-2133524620235079014-n.jpg',
                'category' => 'events',
                'link' => 'https://www.facebook.com/share/p/18qTYFjB4m/?mibextid=wwXIfr',
            ],
            [
                'title' => 'මැවිසුරු රඟසොබා - 2025',
                'description' => 'Album 2',
                'type' => 'image',
                'file_path' => 'https://i.ibb.co/mrfZ1BLQ/539928303-1284745606774763-2133524620235079014-n.jpg',
                'category' => 'events',
                'link' => 'https://www.facebook.com/share/p/1BMNnEZ3Sw/?mibextid=wwXIfr',
            ],
            [
                'title' => 'මැවිසුරු රඟසොබා - 2025',
                'description' => 'Album 3',
                'type' => 'image',
                'file_path' => 'https://i.ibb.co/mrfZ1BLQ/539928303-1284745606774763-2133524620235079014-n.jpg',
                'category' => 'events',
                'link' => 'https://www.facebook.com/share/p/1B3hpn9S8Z/?mibextid=wwXIfr',
            ]
        ];

        foreach ($galleryItems as $item) {
            GalleryItem::create($item);
        }

        $this->command->info('Gallery items seeded successfully!');
    }
}