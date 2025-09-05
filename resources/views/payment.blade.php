<?php
$orderId = $orderId ?? null;
?>

<x-layouts.public>
    <livewire:payment :orderId="$orderId" />
</x-layouts.public>