@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Organization Settings" />

<div class="space-y-6">

    {{-- Header --}}
    <div
        class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-start justify-between flex-wrap gap-5">

            <div>

                <div class="mb-3">

                    <span
                        class="rounded-full bg-blue-100 px-4 py-1 text-sm font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-300">

                        Organization Settings

                    </span>

                </div>

                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                    Himpunan Mahasiswa Informatika
                </h1>

                <p class="mt-3 text-gray-500 dark:text-gray-400">
                    Kelola organization, members, roles, dan permissions.
                </p>

            </div>

        </div>

    </div>

    {{-- Settings Menu --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- Left --}}
        <div class="space-y-6">

            {{-- Organization --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

                <h2 class="mb-5 text-xl font-bold text-gray-800 dark:text-white">
                    Organization
                </h2>

                <div class="flex flex-col gap-3">

                    <a href="{{ route('organizations.edit', 1) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

                        Edit Organization

                    </a>

                    <a href="#"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

                        Manage Members

                    </a>

                    <a href="#"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

                        Manage Divisions

                    </a>

                </div>

            </div>

            {{-- Permissions --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

                <h2 class="mb-5 text-xl font-bold text-gray-800 dark:text-white">
                    Permissions
                </h2>

                <div class="flex flex-col gap-3">

                    <a href="#"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

                        Edit Permissions

                    </a>

                </div>

            </div>

        </div>

        {{-- Right --}}
        <div>

            {{-- Roles --}}
            {{-- Roles --}}
<div
    class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

    <div class="mb-6 flex items-center justify-between">

        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
            Roles
        </h2>

        <a href="#"
            class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition">

            Tambah Role

        </a>

    </div>

    <div class="space-y-3">

        {{-- Role Item --}}
        <div
            class="flex items-center justify-between rounded-xl border border-gray-200 p-4 dark:border-gray-700">

            <h3 class="font-medium text-gray-800 dark:text-white">
                Admin Organization
            </h3>

            <button
                class="flex h-9 w-9 items-center justify-center rounded-xl border border-red-200 text-red-500 hover:bg-red-50 dark:border-red-800 dark:hover:bg-red-900/20 transition">

                ✕

            </button>

        </div>

        {{-- Role Item --}}
        <div
                        class="flex items-center justify-between rounded-xl border border-gray-200 p-4 dark:border-gray-700">

                        <h3 class="font-medium text-gray-800 dark:text-white">
                            Bendahara
                        </h3>

                        <button
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-red-200 text-red-500 hover:bg-red-50 dark:border-red-800 dark:hover:bg-red-900/20 transition">

                            ✕

                        </button>
                        
                    </div>

                    {{-- Role Item --}}
                    <div
                        class="flex items-center justify-between rounded-xl border border-gray-200 p-4 dark:border-gray-700">

                        <h3 class="font-medium text-gray-800 dark:text-white">
                            Staff Media
                        </h3>

                        <button
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-red-200 text-red-500 hover:bg-red-50 dark:border-red-800 dark:hover:bg-red-900/20 transition">

                            ✕

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection