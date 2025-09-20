<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.1/Sortable.min.js"></script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<!-- EasyMDE CSS and JS for Markdown Editor -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

@php
    // Define default social meta data
    $defaultSocial = [
        'title' => ($title ?? config('app.name')) . ' - Engineering Faculty Students Union',
        'description' => 'Engineering Faculty Students Union (EFSU) - Connecting engineering students, faculty, and alumni through academic excellence, social engagement, and professional development at the University of Moratuwa.',
        'image' => asset('cover.png'),
        'image_alt' => 'Engineering Faculty Students Union Logo',
        'type' => 'website'
    ];

    // Merge with any provided social data (from Livewire components)
    $social = array_merge($defaultSocial, $socialMeta ?? []);
@endphp

<!-- Social Media Meta Tags -->
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:locale" content="en_US">
<meta property="og:type" content="{{ $social['type'] }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:title" content="{{ $social['title'] }}">
<meta property="og:description" content="{{ $social['description'] }}">
<meta property="og:image" content="{{ $social['image'] }}">
<meta property="og:image:alt" content="{{ $social['image_alt'] }}">
@if(isset($social['image_width']))
    <meta property="og:image:width" content="{{ $social['image_width'] }}">
@endif
@if(isset($social['image_height']))
    <meta property="og:image:height" content="{{ $social['image_height'] }}">
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ config('app.name') }}">
<meta name="twitter:title" content="{{ $social['title'] }}">
<meta name="twitter:description" content="{{ $social['description'] }}">
<meta name="twitter:image" content="{{ $social['image'] }}">

<meta name="description" content="{{ $social['description'] }}">

@if(isset($social['author']))
    <meta name="author" content="{{ $social['author'] }}">
    <meta property="article:author" content="{{ $social['author'] }}">
@endif

@if(isset($social['published_time']))
    <meta property="article:published_time" content="{{ $social['published_time'] }}">
@endif

@if(isset($social['modified_time']))
    <meta property="article:modified_time" content="{{ $social['modified_time'] }}">
@endif

@if(isset($social['section']))
    <meta property="article:section" content="{{ $social['section'] }}">
@endif

@if(isset($social['tags']) && is_array($social['tags']))
    @foreach($social['tags'] as $tag)
        <meta property="article:tag" content="{{ $tag }}">
    @endforeach
@endif

@if(isset($social['structured_data']))
    <script type="application/ld+json">
    {!! json_encode($social['structured_data'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endif

@stack('head')
