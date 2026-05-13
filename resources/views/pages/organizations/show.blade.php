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

                    <a href="#"
                        class="inline-flex items-center justify-center rounded-xl bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition">

                        Tambah Transaksi

                    </a>

                    <a href="#"
                        class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-amber-600 transition">

                        Buat Divisi

                    </a>

                    <a href="#"
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

        <h2 class="text-2xl font-bold mb-5 text-gray-800 dark:text-white">
            Daftar Divisi
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

            @forelse($organization->divisions as $division)

                <div class="border rounded-2xl p-5">

                    <h3 class="text-xl font-semibold">
                        {{ $division->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        {{ $division->description }}
                    </p>

                </div>

            @empty

                <p class="text-gray-500">
                    Belum ada divisi.
                </p>

            @endforelse

        </div>

    </div>

</div>

@endsection