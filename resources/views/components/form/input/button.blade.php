@props([
    'type' => 'button',
])

<button
    type="{{ $type }}"

    {{ $attributes->merge([
        'class' =>
            'bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl transition'
    ]) }}
>
    {{ $slot }}
</button>