@props([
    'label' => '',
    'name' => '',
])

<div>

    @if($label)
        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $label }}
        </label>
    @endif

    <select
        name="{{ $name }}"

        {{ $attributes->merge([
            'class' =>
                'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white'
        ]) }}
    >

        {{ $slot }}

    </select>

</div>