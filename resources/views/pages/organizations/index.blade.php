@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="All Organizations" />

<div class="p-6 border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    <!-- GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">

        @forelse($organizations as $organization)

            @php

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

                    @php

                        $isJoined = $organization->userOrganizations
                            ->contains('user_id', auth()->id());

                    @endphp

                    <div class="flex items-center justify-between mt-6">

                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            👥 {{ $organization->userOrganizations->count() }} Member
                        </span>

                        @if($isJoined)

                            <a href="{{ route('organizations.show', $organization) }}"
                                class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-xl transition">

                                Lihat

                            </a>

                        @else

                            <a href="{{ route('organization.memberJoin.create', $organization) }}"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl transition">

                                Enroll

                            </a>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div
                class="col-span-full rounded-3xl border border-dashed border-gray-300 dark:border-gray-700 p-12 text-center">

                <h3 class="text-xl font-semibold text-gray-700 dark:text-white">
                    Belum ada organisasi
                </h3>

                <p class="mt-2 text-gray-500 dark:text-gray-400">
                    Organisasi belum tersedia.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection