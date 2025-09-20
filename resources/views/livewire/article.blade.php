<?php

use App\Models\NewsArticle;
use Livewire\Volt\Component;

new class extends Component {
    public NewsArticle $article;

    public function mount(NewsArticle $article)
    {
        $this->article = $article;
        
        // Set social meta data for this article
        $this->setSocialMeta();
    }
    
    private function setSocialMeta()
    {
        $socialMeta = [
            'title' => $this->article->title . ' | ' . config('app.name'),
            'description' => $this->article->excerpt ?: Str::limit(strip_tags($this->article->content), 160),
            'type' => 'article',
            'author' => config('app.name'),
            'published_time' => $this->article->published_at->toISOString(),
            'section' => $this->article->category,
            'tags' => [$this->article->category],
        ];
        
        if ($this->article->image_url) {
            $socialMeta['image'] = Storage::url($this->article->image_url);
            $socialMeta['image_alt'] = $this->article->title;
            $socialMeta['image_width'] = '1200';
            $socialMeta['image_height'] = '630';
        }
        
        if ($this->article->updated_at != $this->article->created_at) {
            $socialMeta['modified_time'] = $this->article->updated_at->toISOString();
        }
        
        if ($this->article->is_featured) {
            $socialMeta['tags'][] = 'Featured';
        }
        
        // Add structured data
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $this->article->title,
            'description' => $socialMeta['description'],
            'datePublished' => $this->article->published_at->toISOString(),
            'author' => [
                '@type' => 'Organization',
                'name' => config('app.name')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('android-chrome-192x192.png')
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => request()->url()
            ]
        ];
        
        if ($this->article->image_url) {
            $structuredData['image'] = Storage::url($this->article->image_url);
        }
        
        if ($this->article->updated_at != $this->article->created_at) {
            $structuredData['dateModified'] = $this->article->updated_at->toISOString();
        }
        
        $socialMeta['structured_data'] = $structuredData;
        
        // Make it available to the view
        view()->share('socialMeta', $socialMeta);
    }

    public function getBadgeColor($category)
    {
        return match (strtolower($category)) {
            'news' => 'primary',
            'events' => 'secondary',
            'announcements' => 'accent',
            'academic' => 'info',
            'sports' => 'success',
            'cultural' => 'warning',
            default => 'neutral',
        };
    }
}; ?>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Article Header -->
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary">
                        <x-mary-icon name="o-home" class="w-4 h-4 mr-2" />
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-mary-icon name="o-chevron-right" class="w-5 h-5 text-gray-400" />
                        <a href="{{ route('news') }}"
                            class="ml-1 text-sm font-medium text-gray-700 hover:text-primary md:ml-2">News</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-mary-icon name="o-chevron-right" class="w-5 h-5 text-gray-400" />
                        <span
                            class="ml-1 text-sm font-medium text-gray-500 md:ml-2 truncate">{{ Str::limit($article->title, 30) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Article Category Badge -->
        <div class="mb-4">
            <x-mary-badge :value="$article->category" class="badge-{{ $this->getBadgeColor($article->category) }}" />
            @if ($article->is_featured)
                <x-mary-badge value="Featured" class="badge-warning ml-2" />
            @endif
        </div>

        <!-- Article Title -->
        <div class="flex items-start justify-between mb-4">
            <h1 class="text-4xl md:text-5xl font-bold text-base-content flex-1">
                {{ $article->title }}
            </h1>
            @auth
                @if(auth()->user()->isAdmin())
                    <div class="ml-4 mt-2">
                        <x-mary-button 
                            link="{{ route('dashboard.news-articles.edit', $article) }}" 
                            icon="o-pencil"
                            class="btn-ghost btn-sm"
                            tooltip="Edit Article"
                        />
                    </div>
                @endif
            @endauth
        </div>

        <!-- Article Meta -->
        <div class="flex flex-wrap items-center gap-4 text-base-content/70 mb-8">
            <div class="flex items-center">
                <x-mary-icon name="o-calendar-days" class="w-5 h-5 mr-2" />
                <time datetime="{{ $article->published_at->format('Y-m-d') }}">
                    {{ $article->published_at->format('F j, Y') }}
                </time>
            </div>
            <div class="flex items-center">
                <x-mary-icon name="o-clock" class="w-5 h-5 mr-2" />
                <span>{{ ceil(str_word_count(strip_tags($article->content)) / 200) }} min read</span>
            </div>
        </div>

        <!-- Featured Image -->
        @if ($article->image_url)
            <div class="mb-8 max-w-md mx-auto md:max-w-lg">
                <img src="{{ Storage::url($article->image_url) }}" alt="{{ $article->title }}"
                    class="w-full aspect-square object-contain rounded-lg shadow-lg">
            </div>
        @endif
    </div>

    <!-- Article Content -->
    <div class="max-w-4xl mx-auto">
        <article id="mainarticle"
            class="prose prose-lg max-w-none text-base-content">
            {!! Str::markdown($article->content) !!}
        </article>
    </div>

    <!-- Article Footer -->
    <div class="max-w-4xl mx-auto mt-12 pt-8 border-t border-base-200">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <!-- Share Section -->
            <div class="flex items-center gap-4">
                <span class="text-base-content/70 font-medium">Share this article:</span>
                <div class="flex gap-2">
                    <x-mary-button
                        onclick="navigator.share ? navigator.share({title: '{{ addslashes($article->title) }}', url: window.location.href}) : window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank')"
                        class="btn-ghost btn-sm" icon="o-share" /> 
                </div>
            </div>

            <!-- Back to News -->
            <x-mary-button link="{{ route('news') }}" icon="o-arrow-left" class="btn-ghost" label="Back to News" />
        </div>
    </div>

    <!-- Related Articles -->
    @php
        $relatedArticles = NewsArticle::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->where(function ($query) use ($article) {
                $query->where('category', $article->category)->orWhere('is_featured', true);
            })
            ->latest()
            ->take(3)
            ->get();
    @endphp

    @if ($relatedArticles->count() > 0)
        <div class="max-w-6xl mx-auto mt-16">
            <h2 class="text-2xl font-bold text-base-content mb-8">Related Articles</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($relatedArticles as $related)
                    <div class="card bg-base-100 shadow-lg hover:shadow-xl transition-shadow duration-300">
                        @if ($related->image_url)
                            <figure class="aspect-video overflow-hidden">
                                <img src="{{ Storage::url($related->image_url) }}" alt="{{ $related->title }}"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </figure>
                        @endif
                        <div class="card-body p-6">
                            <div class="mb-2">
                                <x-mary-badge :value="$related->category"
                                    class="badge-{{ $this->getBadgeColor($related->category) }} badge-sm" />
                            </div>
                            <h3 class="card-title text-lg mb-2 line-clamp-2">{{ $related->title }}</h3>
                            <p class="text-base-content/70 text-sm mb-4 line-clamp-3">{{ $related->excerpt }}</p>
                            <div class="card-actions justify-between items-center">
                                <span class="text-xs text-base-content/60">
                                    {{ $related->published_at->format('M j, Y') }}
                                </span>
                                <x-mary-button link="{{ route('article', $related) }}" label="Read More"
                                    class="btn-sm btn-primary" size="sm" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
