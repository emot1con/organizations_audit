@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Tambah Role Division" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Buat Role Division">

            {{-- FORM --}}
            <form
                action="{{ route('division.roles.store', $division) }}"
                method="POST"
            >

                @csrf

                {{-- Nama Organization --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama Organisasi"
                    type="text"
                    value="{{ $organization->name }}"
                    disabled="true"
                />

                {{-- Nama Division --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama Division"
                    type="text"
                    value="{{ $division->name }}"
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
                    value="Division"
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
                                class="flex items-start justify-between gap-4 rounded-xl border border-gray-200 p-4 transition hover:border-orange-300 dark:border-gray-700 dark:hover:border-orange-700"
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
                    class="mb-6 rounded-2xl border border-orange-200 bg-orange-50 p-4 text-sm text-orange-700 dark:border-orange-800 dark:bg-orange-900/20 dark:text-orange-300"
                >

                    Role baru akan otomatis terhubung dengan division

                    <span class="font-semibold">

                        {{ $division->name }}

                    </span>.

                </div>

                {{-- Button --}}
                <div class="flex justify-end">

                    <x-form.input.button type="submit">

                        Tambah Role

                    </x-form.input.button>

                </div>

            </form>

        </x-common.component-card>

    </div>

</div>

@endsection