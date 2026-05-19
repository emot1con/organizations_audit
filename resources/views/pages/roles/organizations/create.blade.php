@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Tambah Role Organization" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Buat Role Organization">

            {{-- FORM --}}
            <form
                action="{{ route('organization.roles.store', $organization) }}"
                method="POST"
            >

                @csrf

                {{-- Nama Organisasi --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama Organisasi"
                    type="text"
                    name="organization_name"
                    value="{{ $organization->name }}"
                    disabled="true"
                />

                {{-- Nama Role --}}
                <x-form.input.input
                    class="mb-2"
                    label="Nama Role"
                    type="text"
                    name="name"
                    placeholder="Masukkan nama role"
                    value="{{ old('name') }}"
                />

                @error('name')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

                {{-- Scope --}}
                <x-form.input.input
                    class="mb-5"
                    label="Scope"
                    type="text"
                    name="scope"
                    value="Organization"
                    disabled="true"
                />

                {{-- Permissions --}}
                <div class="mb-6">

                    <h3 class="mb-4 text-sm font-semibold text-gray-700 dark:text-gray-300">

                        Permissions

                    </h3>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        @forelse($permissions as $permission)

                            <label
                                class="flex items-start justify-between gap-4 rounded-xl border border-gray-200 p-4 transition hover:border-brand-300 dark:border-gray-700 dark:hover:border-brand-700"
                            >

                                <div>

                                    <h4
                                        class="font-medium text-gray-800 dark:text-white"
                                    >

                                        {{ ucfirst($permission->name) }}

                                    </h4>

                                    <p
                                        class="mt-1 text-xs text-gray-500 dark:text-gray-400"
                                    >

                                        Scope:
                                        {{ ucfirst($permission->scope) }}

                                    </p>

                                </div>

                                <x-form.input.toggle
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    :checked="in_array(
                                        $permission->id,
                                        old('permissions', [])
                                    )"
                                />

                            </label>

                        @empty

                            <div
                                class="col-span-full rounded-xl border border-dashed border-gray-300 p-6 text-center dark:border-gray-700"
                            >

                                <h3
                                    class="text-sm font-semibold text-gray-700 dark:text-white"
                                >

                                    Belum ada permission

                                </h3>

                                <p
                                    class="mt-2 text-xs text-gray-500 dark:text-gray-400"
                                >

                                    Tambahkan permission terlebih dahulu.

                                </p>

                            </div>

                        @endforelse

                    </div>

                    @error('permissions')

                        <p class="mt-3 text-sm text-red-500">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                {{-- Informasi --}}
                <div
                    class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-700 dark:border-blue-800 dark:bg-blue-900/20 dark:text-blue-300"
                >

                    Role baru akan otomatis terhubung dengan organisasi

                    <span class="font-semibold">

                        {{ $organization->name }}

                    </span>.

                </div>

                {{-- Button --}}
                <div class="flex justify-end gap-3">

                {{-- Back --}}
                <a
                    href="{{ url()->previous() }}"
                    class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition"
                >

                    Back

                </a>

                {{-- Submit --}}
                <x-form.input.button type="submit">

                    Tambah Role

                </x-form.input.button>

            </div>

            </form>

        </x-common.component-card>

    </div>

</div>

@endsection