@props([

    'label' => '',

    'name' => '',

    'accept' => '',

])

<div class="{{ $attributes->get('class') }}">

    {{-- Label --}}
    @if($label)

        <label
            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
        >

            {{ $label }}

        </label>

    @endif

    {{-- Input File --}}
    <input
        type="file"
        name="{{ $name }}"
        accept="{{ $accept }}"
        {{ $attributes->except('class') }}
        class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-gray-200 file:bg-gray-50 file:px-3.5 file:py-3 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:text-white/90 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400"
    >

    {{-- Error --}}
    @error($name)

        <p class="mt-2 text-sm text-red-500">

            {{ $message }}

        </p>

    @enderror

</div>