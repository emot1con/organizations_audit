@props([
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'rows' => 4,
])

<div>

    @if($label)
        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $label }}
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"

        {{ $attributes->merge([
            'class' =>
                'w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white'
        ]) }}

    ></textarea>

</div>