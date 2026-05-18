@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb :pageTitle="$division->name" />

<div class="space-y-6">

    {{-- Header Division --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-start justify-between flex-wrap gap-5">

            <div>

                <div class="flex items-center gap-3 mb-3">

                    <span
                        class="bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300 text-xs px-3 py-1 rounded-full">

                        {{ $division->category }}

                    </span>

                </div>

                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                    {{ $division->name }}
                </h1>

                <p class="mt-3 text-gray-500 dark:text-gray-400 max-w-2xl">
                    Divisi ini berada di dalam organisasi
                    <span class="font-semibold">
                        {{ $division->organization->name }}
                    </span>
                </p>

            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3">

                @if(!$isJoined)

                <form
                    action="{{ route('divisions.join', $division) }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-orange-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-orange-600 transition">

                        Join Division

                    </button>

                </form>

            @endif

                <a href="{{ route('divisions.transactions.create', $division) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition">

                    Tambah Transaksi

                </a>

                <a href="{{ route('divisions.transactions.index', $division) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-green-600 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-green-800 transition">

                    Lihat Transaksi

                </a>    

                

                <a href="{{ route('divisions.settings', $division) }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

                    ⚙ Settings

                </a>

            </div>

        </div>

    </div>

    {{-- Metrics --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Members --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <span class="text-sm text-gray-500">
                Total Member
            </span>

            <h2 class="mt-3 text-3xl font-bold text-gray-800 dark:text-white">
                {{ $division->userOrganizations->count() }}
            </h2>

        </div>

        {{-- Division Cash --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <span class="text-sm text-gray-500">
                Kas Divisi
            </span>

            <h2 class="mt-3 text-2xl font-bold text-gray-800 dark:text-white">
                Rp {{ number_format($division->division_cash, 0, ',', '.') }}
            </h2>

        </div>

        {{-- Total Transactions --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <span class="text-sm text-gray-500">
                Total Transaksi
            </span>

            <h2 class="mt-3 text-3xl font-bold text-gray-800 dark:text-white">
                {{ $division->transactions->count() }}
            </h2>

        </div>

        {{-- Category --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <span class="text-sm text-gray-500">
                Category
            </span>

            <h2 class="mt-3 text-lg font-bold text-gray-800 dark:text-white">
                {{ $division->category }}
            </h2>

        </div>

    </div>

    {{-- Members Table --}}
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">

        {{-- Header --}}
        <div class="flex flex-col gap-4 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div>

                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Member Divisi
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Seluruh anggota yang tergabung di dalam divisi.
                </p>

            </div>

            <div class="flex items-center gap-3">

                <input type="text"
                    placeholder="Search member..."
                    class="h-11 rounded-xl border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white xl:w-[280px]">

            </div>

        </div>

        {{-- Table --}}
        <div class="overflow-hidden">

            <div class="max-w-full overflow-x-auto px-5">

                <table class="min-w-full">

                    <thead>

                        <tr class="border-y border-gray-200 dark:border-gray-700">

                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">
                                Member
                            </th>

                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">
                                Role
                            </th>

                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">
                                Joined
                            </th>


                            
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                        @forelse($division->userOrganizations as $member)

                            <tr>

                                {{-- Member --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-500 font-semibold text-white">

                                            {{ strtoupper(substr($member->user->name, 0, 1)) }}

                                        </div>

                                        <div>

                                            <h4 class="font-medium text-gray-800 dark:text-white">

                                                {{ $member->user->name }}

                                            </h4>

                                            <p class="text-sm text-gray-500">

                                                {{ $member->user->email }}

                                            </p>

                                        </div>

                                    </div>

                                </td>

                                {{-- Role --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="rounded-full bg-blue-100 px-3 py-1 text-xs text-blue-600 dark:bg-blue-900 dark:text-blue-300">

                                        {{ $member->role->name }}

                                    </span>

                                </td>

                                {{-- Joined --}}
                                <td class="px-5 py-4 text-sm text-gray-500">

                                    {{ $member->created_at->translatedFormat('d F Y') }}

                                </td>

                                

                                

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-5 py-10 text-center">

                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white">
                                        Belum ada anggota
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Divisi ini belum memiliki anggota.
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