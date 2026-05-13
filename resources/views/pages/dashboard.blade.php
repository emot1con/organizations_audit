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
        @auth
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

                @forelse($organizations as $item)

                    @php
                        $organization = $item->organization;

                        $categories = [
                            'Technology',
                            'Business',
                            'Education',
                            'Creative',
                            'Programming',
                            'Community'
                        ];

                        $randomCategory = $categories[array_rand($categories)];

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
                        class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                        <img
                            src="https://images.unsplash.com/photo-1498050108023-c5249f4df085"
                            class="w-full h-48 object-cover">

                        <div class="p-6">

                            <div class="flex items-center justify-between">

                                <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                                    {{ $organization->name }}
                                </h2>

                                <span class="{{ $randomBadge }} text-xs px-3 py-1 rounded-full">
                                    {{ $randomCategory }}
                                </span>

                            </div>

                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-3 line-clamp-2">

                                {{ $organization->description ?? 'Belum ada deskripsi organisasi.' }}

                            </p>

                            <div class="flex items-center justify-between mt-6">

                                <span class="text-gray-500 dark:text-gray-400 text-sm">
                                    👥 {{ $organization->userOrganizations->count() }} Member
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
        @endauth
        @endsection
