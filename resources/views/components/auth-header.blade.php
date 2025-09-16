@props(['title', 'description' => null])

<div class="text-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $title }}</h1>
    @if($description)
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $description }}</p>
    @endif
</div>
