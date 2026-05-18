@props([

    'label' => '',

    'name' => '',

    'checked' => false,

    'disabled' => false,

])

<div
    x-data="{

        switcherToggle: @js(old($name, $checked))

    }"
>

    <label
        class="flex cursor-pointer items-center gap-3 text-sm font-medium
        {{ $disabled
            ? 'text-gray-400'
            : 'text-gray-700 dark:text-gray-400'
        }}
        select-none"
    >

        <div class="relative">

            <input
                type="checkbox"
                name="{{ $name }}"
                class="sr-only"
                x-model="switcherToggle"
                {{ $disabled ? 'disabled' : '' }}
            />

            <div
                class="block h-6 w-11 rounded-full transition"

                :class="
                    switcherToggle
                        ? 'bg-brand-500 dark:bg-brand-500'
                        : '{{ $disabled
                            ? 'bg-gray-100 dark:bg-gray-800'
                            : 'bg-gray-200 dark:bg-white/10'
                        }}'
                "
            ></div>

            <div
                class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear"

                :class="
                    switcherToggle
                        ? 'translate-x-full'
                        : 'translate-x-0'
                "
            ></div>

        </div>

        {{ $label }}

    </label>

</div>