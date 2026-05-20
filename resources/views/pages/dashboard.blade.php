        @extends('layouts.app')

        @section('content')
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6 xl:col-span-12">
            <x-ecommerce.ecommerce-metrics />
            {{-- <x-ecommerce.monthly-sale /> --}}
            </div>
            {{-- <div class="col-span-12 xl:col-span-5">
                <x-ecommerce.monthly-target />
            </div> --}}

            {{-- <div class="col-span-12">
            <x-ecommerce.statistics-chart />
            </div>

            <div class="col-span-12 xl:col-span-5">
            <x-ecommerce.customer-demographic />
            </div>

            <div class="col-span-12 xl:col-span-7">
            <x-ecommerce.recent-orders />
            </div> --}}
        </div>
        @if (auth()->user()->role?->name === 'user')
            
        <div class="p-6">

            <!-- HEADER -->
            <div class="flex items-center justify-between mb-8">

                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                        Organisasi Saya
                    </h1>

                </div>

            </div>

            
            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">

            @forelse($organizations as $organization)

                @php

                    $badgeColors = [
                        'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300',
                        'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-300',
                        'bg-orange-100 text-orange-600 dark:bg-orange-900 dark:text-orange-300',
                        'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300',
                        'bg-pink-100 text-pink-600 dark:bg-pink-900 dark:text-pink-300',
                    ];

                    $randomBadge = $badgeColors[array_rand($badgeColors)];
                @endphp

                <div
                    class="flex flex-col h-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                    <img
                        src="{{ $organization->photo
                            ? asset('storage/' . $organization->photo)
                            : 'https://placehold.net/600x400.png'
                        }}"
                        class="w-full h-48 object-cover"
                    >

                    <div class="flex flex-col flex-1 p-6">

                        {{-- Header --}}
                        <div class="flex items-center justify-between">

                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                                {{ $organization->name }}
                            </h2>

                            <span class="{{ $randomBadge }} text-xs px-3 py-1 rounded-full">
                                {{ $organization->category_organizations }}
                            </span>

                        </div>

                        {{-- Description --}}
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-3 line-clamp-2">

                            {{ $organization->description ?? 'Belum ada deskripsi organisasi.' }}

                        </p>

                        {{-- Footer --}}
                        <div class="mt-auto flex items-center justify-between pt-6">

                            <span class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>


                                {{ $organization->total_members }} Member

                            </span>

                            <a href="{{ route('organizations.show', $organization) }}"
                                class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-xl transition">

                                Lihat

                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div
                    class="col-span-full rounded-3xl border border-dashed border-gray-300 dark:border-gray-700 p-12 text-center">

                    <h3 class="text-xl font-semibold text-gray-700 dark:text-white">
                        Kamu belum join organisasi
                    </h3>

                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        Mulai buat organisasi pertamamu.
                    </p>

                    <a href="{{ route('organizations.create') }}"
                        class="inline-flex items-center mt-5 bg-brand-500 hover:bg-brand-600 text-white px-5 py-3 rounded-xl transition">

                        + Buat Organisasi

                    </a>

                </div>

            @endforelse

        </div>
        
        

        </div>

        @endif

        @endsection
