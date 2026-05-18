@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Permission Settings" />

<div class="space-y-6">

    {{-- Header --}}
    <div
        class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-start justify-between flex-wrap gap-5">

            <div>

                <div class="mb-3 flex items-center gap-3">

                    <span
                        class="rounded-full bg-blue-100 px-3 py-1 text-xs text-blue-600 dark:bg-blue-900 dark:text-blue-300">

                        {{ $organization->category_organizations }}

                    </span>

                </div>

                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">

                    {{ $organization->name }}

                </h1>

                <p class="mt-3 max-w-2xl text-gray-500 dark:text-gray-400">

                    Pengaturan permission untuk setiap role organisasi.

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

                    Organization Permissions

                </h3>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">

                    Kelola permission setiap role organisasi.

                </p>

            </div>

        </div>

        <div class="overflow-hidden">

            <div class="max-w-full overflow-x-auto px-5">

                <form
                    action="{{ route('organization.permissions.update', $organization) }}"
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
                                                class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-500 font-semibold text-white">

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

                                                    $isOwnerRole = in_array(
                                                        strtolower($role->name),
                                                        [

                                                            'ketua umum',

                                                            'owner',

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
                                                    :disabled="$isOwnerRole"
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

                                            Organisasi ini belum memiliki role
                                            organisasi.

                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                    {{-- Footer --}}
                    <div
                        class="flex items-center justify-end border-t border-gray-200 px-6 py-5 dark:border-gray-800">

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600">

                            Simpan Permission

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection