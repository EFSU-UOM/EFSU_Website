<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Seeder;

class NewsArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Congratulations to the 2024/25 Engineering Intake',
                'excerpt' => 'Warmest congratulations to all who have been selected for the Faculty of Engineering, University of Moratuwa for the 2024/25 academic year!',
                'content' => 'Warmest congratulations to all of you who have been selected for the Faculty of Engineering, University of Moratuwa for the 2024/25 academic year..!<br><br>For any problems that arise during registration at the university, please contact:<br><a href="tel:+94717875495">Pivithuru - 071 787 5495</a><br><a href="tel:+94763510388">Gishan - 076 351 0388</a><br><br>Faculty of Engineering Students\' Union,<br>University of Moratuwa',
                'category' => 'general',
                'image_url' => 'https://i.ibb.co/ZpT74My2/t.jpg',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(21)
            ]
        ];

        foreach ($articles as $article) {
            NewsArticle::create($article);
        }

        $this->command->info('News articles seeded successfully!');
    }
}