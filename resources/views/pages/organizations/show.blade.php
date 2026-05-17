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

                <a href="{{ route('organizations.transactions.create', $organization) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition">

                    Tambah Transaksi

                </a>

                <a href="{{ route('organizations.transactions.index', $organization) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-green-600 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-green-800 transition">

                    Lihat Transaksi

                </a>

                <a href="{{ route('organizations.divisions.create', $organization) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-amber-600 transition">

                    Buat Divisi

                </a>

                <a href="{{ route('organizations.settings', $organization) }}"
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
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <span class="text-sm text-gray-500 ">
                Total Member
            </span>

            <h2 class="mt-3 text-3xl font-bold text-gray-800 dark:text-white">
                {{ $organization->userOrganizations->count() }}
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

                    $images = [
                        'https://images.unsplash.com/photo-1498050108023-c5249f4df085',
                        'https://images.unsplash.com/photo-1516321318423-f06f85e504b3',
                        'https://images.unsplash.com/photo-1522202176988-66273c2fd55f',
                        'https://images.unsplash.com/photo-1519389950473-47ba0277781c',
                        'https://images.unsplash.com/photo-1521737604893-d14cc237f11d',
                    ];

                    $randomImage = $images[array_rand($images)];

                @endphp

                <div
                    class="flex flex-col h-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                    <img
                        src="{{ $randomImage }}"
                        class="w-full h-48 object-cover">

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

                            <span class="text-gray-500 dark:text-gray-400 text-sm">
                                👥 {{ $division->userOrganizations->count() }} Member
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