@props(['link' => '#', 'text' => '', 'active' => false])

<a href="{{ $link }}" 
   class="text-gray-600 hover:text-blue-600 font-medium transition-colors {{ $active ? 'text-blue-600' : '' }}">
    {{ $text }}
</a>