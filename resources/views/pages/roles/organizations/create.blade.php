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
                    class="mb-5"
                    label="Nama Role"
                    type="text"
                    name="name"
                    placeholder="Masukkan nama role"
                    value="{{ old('name') }}"
                />

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

                        {{-- Create --}}
                        <div
                            class="rounded-xl border border-gray-200 p-4 dark:border-gray-700"
                        >

                            <x-form.input.toggle
                                type="toggle"
                                label="Create Permission"
                                name="can_create"
                                placeholder="Izinkan membuat data"
                                :checked="old('can_create')"
                            />

                        </div>

                        {{-- Read --}}
                        <div
                            class="rounded-xl border border-gray-200 p-4 dark:border-gray-700"
                        >

                            <x-form.input.toggle
                                type="toggle"
                                label="Read Permission"
                                name="can_read"
                                placeholder="Izinkan melihat data"
                                :checked="old('can_read', true)"
                            />

                        </div>

                        {{-- Update --}}
                        <div
                            class="rounded-xl border border-gray-200 p-4 dark:border-gray-700"
                        >

                            <x-form.input.toggle
                                type="toggle"
                                label="Update Permission"
                                name="can_update"
                                placeholder="Izinkan mengubah data"
                                :checked="old('can_update')"
                            />

                        </div>

                        {{-- Delete --}}
                        <div
                            class="rounded-xl border border-gray-200 p-4 dark:border-gray-700"
                        >

                            <x-form.input.toggle
                                type="toggle"
                                label="Delete Permission"
                                name="can_delete"
                                placeholder="Izinkan menghapus data"
                                :checked="old('can_delete')"
                            />

                        </div>

                    </div>

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