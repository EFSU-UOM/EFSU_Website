<?php
$title = $post->title;
?>

<x-layouts.public>
    <livewire:forum-post-view :postId="$post->id"/>
</x-layouts.public>