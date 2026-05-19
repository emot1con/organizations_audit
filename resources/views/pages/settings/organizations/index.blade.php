@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Organization Settings" />

<div class="space-y-6">

    {{-- Header --}}
    <div
    class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]"
    >

        <div class="flex items-start justify-between flex-wrap gap-5">

            {{-- LEFT --}}
            <div>

                <div class="mb-3">

                    <span
                        class="rounded-full bg-blue-100 px-4 py-1 text-sm font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-300"
                    >

                        Organization Settings

                    </span>

                </div>

                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">

                    {{ $organization->name }}

                </h1>

                <p class="mt-3 text-gray-500 dark:text-gray-400">

                    Kelola organization, members, roles, dan permissions.

                </p>

            </div>

            {{-- RIGHT --}}
            <a
                href="{{ route('organizations.show', $organization)}}"
                class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition"
            >

                Kembali Ke Beranda  

            </a>

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

                @if(auth()->user()->hasOrganizationPermission($organization->id,'organisasi'))
                    <a href="{{ route('organizations.edit', $organization) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

                        Edit Organization

                    </a>
                @endif

                    <a href="{{ route('organization.users.index', $organization) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

                        Manage Members

                    </a>

                    @if(auth()->user()->hasOrganizationPermission($organization->id,'divisi'))
                    <a href="{{ route('organization.divisions.index', $organization) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

                        Manage Divisions

                    </a>
                    @endif
                    
                    <form
                        action="{{ route('organizations.destroy', $organization) }}"
                        method="POST"
                        class="w-full"
                        onsubmit="return confirm('Yakin ingin menghapus organisasi ini? Semua data akan ikut terhapus.')"
                    >

                        @csrf
                        @method('DELETE')

                    @if(auth()->user()->hasOrganizationPermission($organization->id,'role'))
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-xl border border-red-300 bg-white px-5 py-3 text-sm font-medium text-red-500 hover:bg-red-50 dark:border-red-800 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20 transition"
                        >

                            Hapus Organisasi

                        </button>
                    @endif
                    
                    </form>

                </div>

            </div>

            {{-- Permissions --}}
            @if(auth()->user()->hasOrganizationPermission($organization->id,'role'))
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h2 class="mb-5 text-xl font-bold text-gray-800 dark:text-white">
                    Permissions
                </h2>

                <div class="flex flex-col gap-3">

                    <a href="{{ route('organization.roles.index', $organization) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

                        Edit Permissions

                    </a>

                </div>

            </div>
            @endif

        </div>

        {{-- Right --}}
        <div>

            {{-- Roles --}}
        <div
            class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">

                <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                    Roles
                </h2>

                @if(auth()->user()->hasOrganizationPermission($organization->id,'role'))
                <a href="{{ route('organization.roles.create', $organization) }}"
                    class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition">

                    Tambah Role

                </a>
                @endif

            </div>

            {{-- Roles List --}}
            <div class="space-y-3">

            @forelse($organization->roles as $role)

                <div
                    class="flex items-center justify-between rounded-xl border border-gray-200 p-4 dark:border-gray-700">

                    <div>

                        <h3 class="font-medium text-gray-800 dark:text-white">

                            {{ $role->name }}

                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">

                            Scope:
                            {{ ucfirst($role->scope) }}

                        </p>

                    </div>

                    @if(
                        $role->name !== 'Anggota' &&
                        $role->name !== 'Ketua Umum'
                    )

                        <form
                            action="{{ route('organization.roles.destroy', [$organization, $role]) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus role {{ $role->name }}?')"
                        >

                            @csrf
                            @method('DELETE')

                            @if(auth()->user()->hasOrganizationPermission($organization->id,'role'))
                            <button
                                type="submit"
                                class="flex h-9 w-9 items-center justify-center rounded-xl border border-red-200 text-red-500 hover:bg-red-50 dark:border-red-800 dark:hover:bg-red-900/20 transition">

                                ✕

                            </button>
                            @endif

                        </form>

                    @else

                        <span
                            class="rounded-xl border border-gray-200 px-3 py-2 text-xs font-medium text-gray-400 dark:border-gray-700 dark:text-gray-500">

                            Default

                        </span>

                    @endif

                </div>

            @empty

                <div
                    class="rounded-xl border border-dashed border-gray-300 p-6 text-center dark:border-gray-700">

                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white">
                        Belum ada role
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Tambahkan role baru untuk organisasi ini.
                    </p>

                </div>

            @endforelse

        </div>

        </div>
    
@endsection