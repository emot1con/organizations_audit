@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb :pageTitle="$organization->name" />

<div class="space-y-6">

    {{-- Header Organization --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-start justify-between flex-wrap gap-5">

            <div>

                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                    {{ $organization->name }}
                </h1>

                <p class="mt-3 text-gray-500 dark:text-gray-400 max-w-2xl">
                    {{ $organization->description }}
                </p>

            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3">

                @if(auth()->user()->hasOrganizationPermission($organization->id,'transaksi'))
                <a href="{{ route('organizations.transactions.create', $organization) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition">

                    Tambah Transaksi

                </a>
                @endif

                <a href="{{ route('organizations.transactions.index', $organization) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-green-600 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-green-800 transition">

                    Lihat Transaksi

                </a>

                @if(auth()->user()->hasOrganizationPermission($organization->id,'divisi'))
                <a href="{{ route('organizations.divisions.create', $organization) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-amber-600 transition">

                    Buat Divisi

                </a>
                @endif

                <a href="{{ route('organizations.settings.index', $organization) }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

                    ⚙ Settings

                </a>

            </div>

        </div>

    </div>

    {{-- Metrics --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Divisions --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <span class="text-sm text-gray-500">
                Total Divisi
            </span>

            <h2 class="mt-3 text-3xl font-bold text-gray-800 dark:text-white">
                {{ $organization->divisions->count() }}
            </h2>

        </div>

        {{-- Total Members --}}
        <div class="rounded-2x  l border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <span class="text-sm text-gray-500 ">
                Total Member
            </span>

            <h2 class="mt-3 text-3xl font-bold text-gray-800 dark:text-white">
                {{ $organization->userOrganizations->whereNull('division_id')->count()}}
            </h2>

        </div>

        {{-- Cash --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <span class="text-sm text-gray-500">
                Kas Organisasi
            </span>

            <h2 class="mt-3 text-2xl font-bold text-gray-800 dark:text-white">
                Rp {{ number_format($organization->organizations_cash, 0, ',', '.') }}
            </h2>

        </div>

        {{-- Contact --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <span class="text-sm text-gray-500">
                Contact
            </span>

            <h2 class="mt-3 text-sm font-bold text-gray-800 break-words dark:text-white">
                {{ $organization->contact }}
            </h2>

        </div>

    </div>

    {{-- Divisions --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between mb-6 flex-wrap gap-4">

            <div>

                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Daftar Divisi
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Seluruh divisi yang berada di dalam organisasi.
                </p>

            </div>


        </div>

        {{-- Division Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">

            @forelse($organization->divisions as $division)

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
                        src="{{ $division->photo
                            ? asset('storage/' . $division->photo)
                            : 'https://placehold.net/600x400.png'
                        }}"
                        class="w-full h-48 object-cover"
                    >

                    <div class="flex flex-col flex-1 p-6">

                        {{-- Header --}}
                        <div class="flex items-center justify-between">

                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                                {{ $division->name }}
                            </h2>

                            <span
                                class="{{ $randomBadge }} text-xs px-3 py-1 rounded-full">

                                {{ ucfirst($division->category) }}

                            </span>

                        </div>

                        {{-- Description --}}
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-3 line-clamp-2">

                            {{ $division->description ?? 'Belum ada deskripsi divisi.' }}

                        </p>

                        {{-- Stats --}}
                        <div class="mt-5 flex items-center justify-between">

                            <div>

                                <p class="text-xs text-gray-400">
                                    Member
                                </p>

                                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                    {{ $division->userOrganizations->count() }}
                                </h3>

                            </div>

                            <div>

                                <p class="text-xs text-gray-400">
                                    Keuangan
                                </p>

                                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                    Rp {{ number_format($division->division_cash, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div>

                                <p class="text-xs text-gray-400">
                                    Role
                                </p>

                                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                    {{ $division->roles->count() }}
                                </h3>

                            </div>

                        </div>

                        {{-- Footer --}}
                        <div class="mt-auto flex items-center justify-between pt-6">

                            <span class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>


                                {{ $division->userOrganizations->count() }} Member

                            </span>

                            <a href="{{ route('divisions.show', $division) }}"
                                class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-xl transition">

                                Lihat Divisi

                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div
                    class="col-span-full rounded-3xl border border-dashed border-gray-300 dark:border-gray-700 p-12 text-center">

                    <h3 class="text-xl font-semibold text-gray-700 dark:text-white">
                        Belum ada divisi
                    </h3>

                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        Organisasi ini belum memiliki divisi.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection