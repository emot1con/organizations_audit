@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Permission Settings Division" />

<div class="space-y-6">

    {{-- Header --}}
    <div
        class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-start justify-between flex-wrap gap-5">

            <div>

                <div class="mb-3 flex items-center gap-3">

                    <span
                        class="rounded-full bg-orange-100 px-3 py-1 text-xs text-orange-600 dark:bg-orange-900 dark:text-orange-300">

                        {{ $division->category }}

                    </span>

                </div>

                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">

                    {{ $division->name }}

                </h1>

                <p class="mt-3 max-w-2xl text-gray-500 dark:text-gray-400">

                    Pengaturan permission untuk setiap role division.

                </p>

            </div>

        </div>

    </div>

    {{-- Table --}}
    <div
        class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">

        <div
            class="mb-4 flex flex-col gap-4 px-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div>

                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-white/90">

                    Division Permissions

                </h3>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">

                    Kelola permission setiap role division.

                </p>

            </div>

        </div>

        <div class="overflow-hidden">

            <div class="max-w-full overflow-x-auto px-5">

                <form
                    action="{{ route('division.permissions.update', $division) }}"
                    method="POST"
                >

                    @csrf
                    @method('PUT')

                    <table class="min-w-full">

                        <thead>

                            <tr
                                class="border-y border-gray-200 dark:border-gray-700">

                                <th
                                    class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">

                                    Role

                                </th>

                                @foreach($permissions as $permission)

                                    <th
                                        class="px-5 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-400">

                                        {{ ucfirst($permission->name) }}

                                    </th>

                                @endforeach

                            </tr>

                        </thead>

                        <tbody
                            class="divide-y divide-gray-200 dark:divide-gray-700">

                            @forelse($roles as $role)

                                <tr>

                                    {{-- Role --}}
                                    <td class="px-5 py-4">

                                        <div
                                            class="flex items-center gap-3">

                                            <div
                                                class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-500 font-semibold text-white">

                                                {{ strtoupper(substr($role->name, 0, 1)) }}

                                            </div>

                                            <div>

                                                <h4
                                                    class="font-medium text-gray-800 dark:text-white">

                                                    {{ $role->name }}

                                                </h4>

                                                <p
                                                    class="text-sm text-gray-500">

                                                    {{ $role->userOrganizations->count() }}
                                                    Member

                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- Permissions --}}
                                    @foreach($permissions as $permission)

                                        <td
                                            class="px-5 py-4 text-center">

                                            <div
                                                class="flex justify-center">

                                                @php

                                                    $isLeaderRole = in_array(
                                                        strtolower($role->name),
                                                        [

                                                            'ketua divisi',

                                                        ]
                                                    );

                                                @endphp

                                                <x-form.input.toggle
                                                    name="permissions[{{ $role->id }}][]"
                                                    value="{{ $permission->id }}"
                                                    :checked="$role
                                                        ->permissions
                                                        ->contains(
                                                            'id',
                                                            $permission->id
                                                        )"
                                                    :disabled="$isLeaderRole"
                                                />

                                            </div>

                                        </td>

                                    @endforeach

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="{{ $permissions->count() + 1 }}"
                                        class="px-5 py-10 text-center">

                                        <h3
                                            class="text-lg font-semibold text-gray-700 dark:text-white">

                                            Belum ada role

                                        </h3>

                                        <p
                                            class="mt-2 text-sm text-gray-500 dark:text-gray-400">

                                            Division ini belum memiliki role.

                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                    {{-- Footer --}}
                    <div
                        class="flex items-center justify-end gap-3 border-t border-gray-200 px-6 py-5 dark:border-gray-800"
                    >

                        {{-- Back --}}
                        <a
                            href="{{ route('divisions.settings', $division) }}"
                            class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition"
                        >

                            Back

                        </a>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="inline-flex h-11 items-center justify-center rounded-xl bg-orange-500 px-5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-orange-600"
                        >

                            Simpan Permission

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection