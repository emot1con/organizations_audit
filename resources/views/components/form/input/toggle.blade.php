@props([

    'label' => '',

    'name' => '',

    'value' => 1,

    'checked' => false,

    'disabled' => false,

])

<div
    x-data="{

        switcherToggle: @js($checked)

    }"
>

    <label
        class="flex cursor-pointer items-center gap-3 select-none"
    >

        <div class="relative">

            <input
                type="checkbox"
                name="{{ $name }}"
                value="{{ $value }}"
                class="sr-only"
                x-model="switcherToggle"
                {{ $disabled ? 'disabled' : '' }}
            />

            <div
                class="block h-6 w-11 rounded-full transition"

                :class="
                    switcherToggle
                        ? 'bg-brand-500'
                        : 'bg-gray-300 dark:bg-gray-700'
                "
            ></div>

            <div
                class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white transition"

                :class="
                    switcherToggle
                        ? 'translate-x-full'
                        : ''
                "
            ></div>

        </div>

        @if($label)

            <span
                class="text-sm font-medium text-gray-700 dark:text-gray-300"
            >

                {{ $label }}

            </span>

        @endif

    </label>

</div>