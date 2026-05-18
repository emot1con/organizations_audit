@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Member Organization" />

<div class="space-y-6">

    {{-- Header Organization --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-start justify-between flex-wrap gap-5">

            <div>

                <div class="flex items-center gap-3 mb-3">

                    <span
                        class="bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300 text-xs px-3 py-1 rounded-full">

                        {{ $organization->category_organizations }}

                    </span>

                </div>

                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                    {{ $organization->name }}
                </h1>

                <p class="mt-3 text-gray-500 dark:text-gray-400 max-w-2xl">
                    Seluruh anggota yang tergabung di dalam organisasi
                    <span class="font-semibold">
                        {{ $organization->name }}
                    </span>
                </p>

            </div>

            

        </div>

    </div>

    

    {{-- Members Table --}}
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">

        {{-- Header --}}
        <div class="flex flex-col gap-4 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div>

                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Member Organization
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Seluruh anggota yang tergabung di dalam organisasi.
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
                                Role Utama
                            </th>

                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">
                                Joined
                            </th>

                            <th class="px-5 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse($members as $member)

                        <tr
                            class="{{ $member->user_id == auth()->id()
                                ? 'bg-blue-50 dark:bg-blue-500/10'
                                : '' }}"
                        >

                            {{-- Member --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full font-semibold text-white
                                        
                                        {{ $member->user_id == auth()->id()
                                            ? 'bg-blue-600 ring-4 ring-blue-100 dark:ring-blue-900/40'
                                            : 'bg-brand-500'
                                        }}
                                        ">

                                        {{ strtoupper(substr($member->user->name, 0, 1)) }}

                                    </div>

                                    <div>

                                        <div class="flex items-center gap-2">

                                            <h4
                                                class="{{ $member->user_id == auth()->id()
                                                    ? 'font-bold text-blue-700 dark:text-blue-300'
                                                    : 'font-medium text-gray-800 dark:text-white'
                                                }}"
                                            >

                                                {{ $member->user->name }}

                                            </h4>

                                            @if($member->user_id == auth()->id())

                                                <span
                                                    class="rounded-full bg-blue-100 px-2 py-1 text-[10px] font-semibold text-blue-600 dark:bg-blue-900/40 dark:text-blue-300">

                                                    You

                                                </span>

                                            @endif

                                        </div>

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

                            {{-- Action --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    @if(
                                        $member->role->name !== 'Ketua Umum'
                                    )

                                        <form
                                            action="{{ route('organization.users.destroy', [$organization, $member]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus anggota ini?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-500 transition hover:bg-red-100 dark:border-red-900 dark:bg-red-900/20 dark:hover:bg-red-900/40">

                                                Hapus

                                            </button>

                                        </form>

                                        <a
                                            href="{{ route('organization.users.edit', [$organization, $member]) }}"
                                            class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-500 transition hover:bg-blue-100 dark:border-blue-900 dark:bg-blue-900/20 dark:hover:bg-blue-900/40"
                                        >

                                            Edit

                                        </a>

                                    @else

                                        <span
                                            class="rounded-xl border border-gray-200 px-3 py-2 text-xs font-medium text-gray-400 dark:border-gray-700 dark:text-gray-500">

                                            Owner

                                        </span>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="px-5 py-10 text-center">

                                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">
                                    Belum ada anggota
                                </h3>

                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Organisasi ini belum memiliki anggota.
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