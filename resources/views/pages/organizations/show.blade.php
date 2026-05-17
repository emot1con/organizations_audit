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

                <a href="/divisions/create"
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

            <h2 class="mt-3 text-lg font-bold text-gray-800 dark:text-white">
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

            {{-- Division Card --}}
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                <img
                    src="https://images.unsplash.com/photo-1498050108023-c5249f4df085"
                    class="w-full h-48 object-cover">

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                            Divisi IT
                        </h2>

                        <span
                            class="bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300 text-xs px-3 py-1 rounded-full">

                            Technology

                        </span>

                    </div>

                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-3 line-clamp-2">

                        Divisi yang bertanggung jawab untuk pengembangan website,
                        aplikasi, dan seluruh kebutuhan teknologi organisasi.

                    </p>

                    {{-- Stats --}}
                    <div class="mt-5 flex items-center justify-between">

                        <div>

                            <p class="text-xs text-gray-400">
                                Member
                            </p>

                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                24
                            </h3>

                        </div>

                        <div>

                            <p class="text-xs text-gray-400">
                                Keuangan
                            </p>

                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                Rp {{ number_format(20000000, 0, ',', '.') }}
                            </h3>

                        </div>

                        <div>

                            <p class="text-xs text-gray-400">
                                Role
                            </p>

                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                4
                            </h3>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between mt-6">

                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            👥 24 Member
                        </span>

                        <a href="/divisions/1"
                            class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-xl transition">

                            Lihat Divisi

                        </a>

                    </div>

                </div>

            </div>

            {{-- Division Card --}}
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                <img
                    src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3"
                    class="w-full h-48 object-cover">

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                            Divisi Media
                        </h2>

                        <span
                            class="bg-pink-100 text-pink-600 dark:bg-pink-900 dark:text-pink-300 text-xs px-3 py-1 rounded-full">

                            Creative

                        </span>

                    </div>

                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-3 line-clamp-2">

                        Mengelola branding organisasi, desain konten,
                        dokumentasi, dan sosial media.

                    </p>

                    {{-- Stats --}}
                    <div class="mt-5 flex items-center justify-between">

                        <div>

                            <p class="text-xs text-gray-400">
                                Member
                            </p>

                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                15
                            </h3>

                        </div>

                        <div>

                            <p class="text-xs text-gray-400">
                                Keuangan
                            </p>

                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                Rp {{ number_format(5000000, 0, ',', '.') }}
                            </h3>

                        </div>

                        <div>

                            <p class="text-xs text-gray-400">
                                Role
                            </p>

                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                5
                            </h3>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between mt-6">

                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            👥 15 Member
                        </span>

                        <a href="/divisions/1"
                            class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-xl transition">

                            Lihat Divisi

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection