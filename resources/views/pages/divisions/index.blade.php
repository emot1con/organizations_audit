@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Division Settings" />

<div class="space-y-6">

    {{-- Header Organization --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-start justify-between flex-wrap gap-5">

            {{-- LEFT --}}
            <div>

                <div class="mb-3 flex items-center gap-3">

                    <span
                        class="rounded-full bg-blue-100 px-3 py-1 text-xs text-blue-600 dark:bg-blue-900 dark:text-blue-300"
                    >

                        {{ $organization->category_organizations }}

                    </span>

                </div>

                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">

                    {{ $organization->name }}

                </h1>

                <p class="mt-3 max-w-2xl text-gray-500 dark:text-gray-400">

                    Seluruh pengaturan divisi yang terdapat di dalam organisasi
                    <span class="font-semibold">

                        {{ $organization->name }}

                    </span>

                </p>

            </div>

            {{-- RIGHT --}}
            <div class="flex items-center gap-3 flex-wrap">

                <a
                    href="{{ url()->previous() }}"
                    class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition"
                >

                    Back

                </a>

                <a
                    href="{{ route('organization.divisions.create', $organization) }}"
                    class="inline-flex h-11 items-center justify-center rounded-xl bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600"
                >

                    Tambah Divisi

                </a>

            </div>

        </div>

    </div>

    {{-- Division Table --}}
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">

        {{-- Header --}}
        <div class="flex flex-col gap-4 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div>

                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Division Organization
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Seluruh divisi yang tergabung di dalam organisasi.
                </p>

            </div>

            <div class="flex items-center gap-3">

                <input
                    type="text"
                    placeholder="Search division..."
                    class="h-11 rounded-xl border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white xl:w-[280px]"
                >

            </div>

        </div>

        {{-- Table --}}
        <div class="overflow-hidden">

            <div class="max-w-full overflow-x-auto px-5">

                <table class="min-w-full">

                    <thead>

                        <tr class="border-y border-gray-200 dark:border-gray-700">

                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">
                                Division
                            </th>

                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">
                                Category
                            </th>

                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">
                                Total Member
                            </th>

                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">
                                Total Role
                            </th>

                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">
                                Division Cash
                            </th>

                            <th class="px-5 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                        @forelse(
                            $organization->divisions
                                ->sortBy(fn($division) => $division->userOrganizations->count())
                            as $division
                        )

                            <tr>

                                {{-- Division --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-500 font-semibold text-white"
                                        >

                                            {{ strtoupper(substr($division->name, 0, 1)) }}

                                        </div>

                                        <div>

                                            <h4 class="font-medium text-gray-800 dark:text-white">

                                                {{ $division->name }}

                                            </h4>

                                            <p class="text-sm text-gray-500">

                                                {{ $division->created_at->translatedFormat('d F Y') }}

                                            </p>

                                        </div>

                                    </div>

                                </td>

                                {{-- Category --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="rounded-full bg-purple-100 px-3 py-1 text-xs text-purple-600 dark:bg-purple-900 dark:text-purple-300"
                                    >

                                        {{ $division->category }}

                                    </span>

                                </td>

                                {{-- Total Member --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="rounded-full bg-blue-100 px-3 py-1 text-xs text-blue-600 dark:bg-blue-900 dark:text-blue-300"
                                    >

                                        {{ $division->userOrganizations->count() }} Member

                                    </span>

                                </td>

                                {{-- Total Role --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="rounded-full bg-green-100 px-3 py-1 text-xs text-green-600 dark:bg-green-900 dark:text-green-300"
                                    >

                                        {{ $division->roles->count() }} Role

                                    </span>

                                </td>

                                {{-- Division Cash --}}
                                <td class="px-5 py-4 text-sm font-medium text-gray-700 dark:text-gray-300">

                                    Rp {{ number_format($division->division_cash, 0, ',', '.') }}

                                </td>

                                {{-- Action --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('divisions.edit', $division) }}"
                                            class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-500 transition hover:bg-blue-100 dark:border-blue-900 dark:bg-blue-900/20 dark:hover:bg-blue-900/40"
                                        >

                                            Edit

                                        </a>

                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('divisions.destroy', $division) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus divisi ini?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-500 transition hover:bg-red-100 dark:border-red-900 dark:bg-red-900/20 dark:hover:bg-red-900/40"
                                            >

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-5 py-10 text-center">

                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white">
                                        Belum ada divisi
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Organisasi ini belum memiliki divisi.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection