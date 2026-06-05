@php
    // defaults
    $link = $link ?? '#';
    $title = $title ?? '';
    $subtitle = $subtitle ?? null;
    $colorClass = $colorClass ?? 'bg-white text-gray-900';
    $borderClass = $borderClass ?? 'border border-gray-200';
@endphp

<a href="{{ $link }}" class="block overflow-hidden p-6 sm:rounded-lg hover:shadow-md transition duration-200 {{ $colorClass }} {{ $borderClass }}">
    <div class="flex items-start justify-between">
        <div>
            <h3 class="text-lg font-bold">{{ $title }}</h3>
            @if($subtitle)
                <p class="text-sm mt-1 text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>

        @isset($icon)
            <div class="shrink-0 ml-4">{{ $icon }}</div>
        @endisset
    </div>

    <div class="mt-4">
        @if(trim($slot) !== '')
            <div class="text-3xl font-bold">{{ $slot }}</div>
        @else
            <div class="text-sm text-gray-600">&nbsp;</div>
        @endif
    </div>
</a>