@props([
    'status',
    'type' => 'success',
    'title' => null,
])

@if ($status)
    <x-alert :type="$type" :title="$title" {{ $attributes }}>
        {{ $status }}
    </x-alert>
@endif
