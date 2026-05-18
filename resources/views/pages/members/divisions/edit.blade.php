@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Edit Member Role Division" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Edit Role Member Division">

            {{-- FORM --}}
            <form
                action="{{ route('division.users.update', [
                    'division' => $division,
                    'member' => $member,
                ]) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                {{-- Nama Organisasi --}}
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

                {{-- Nama Member --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama Member"
                    type="text"
                    value="{{ $member->user->name }}"
                    disabled="true"
                />

                {{-- Role --}}
                <div class="mb-5">

                    <label
                        class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
                    >

                        Role Division

                    </label>

                    <select
                        name="role_id"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-orange-300 focus:ring-orange-500/10 dark:focus:border-orange-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                        @foreach($roles as $role)

                            <option
                                value="{{ $role->id }}"
                                {{ $member->role_id == $role->id ? 'selected' : '' }}
                            >

                                {{ $role->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('role_id')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                {{-- Informasi --}}
                <div
                    class="mb-6 rounded-2xl border border-orange-200 bg-orange-50 p-4 text-sm text-orange-700 dark:border-orange-800 dark:bg-orange-900/20 dark:text-orange-300"
                >

                    Pilih role division yang ingin diberikan kepada member ini.

                </div>

                {{-- Button --}}
                <div class="flex justify-end gap-3">

                    <a
                        href="{{ route('division.users.index', $division) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition"
                    >

                        Batal

                    </a>

                    <x-form.input.button type="submit">

                        Simpan Perubahan

                    </x-form.input.button>

                </div>

            </form>

        </x-common.component-card>

    </div>

</div>

@endsection