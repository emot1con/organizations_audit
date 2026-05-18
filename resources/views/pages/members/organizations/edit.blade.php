@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Edit Member Role" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Edit Role Member">

            {{-- FORM --}}
            <form
                action="{{ route('organization.users.update', [$organization, $member]) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                {{-- Nama Organisasi --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama Organisasi"
                    type="text"
                    name="organization_name"
                    value="{{ $organization->name }}"
                    disabled="true"
                />

                {{-- Nama Member --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama Member"
                    type="text"
                    name="member_name"
                    value="{{ $member->user->name }}"
                    disabled="true"
                />

                {{-- Role --}}
                <div class="mb-5">

                    <label
                        class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
                    >
                        Role Organisasi
                    </label>

                    <select
                        name="role_id"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
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
                    class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-700 dark:border-blue-800 dark:bg-blue-900/20 dark:text-blue-300"
                >

                    Pilih role organisasi yang ingin diberikan kepada member ini.

                </div>

                {{-- Button --}}
                <div class="flex justify-end">

                    <x-form.input.button type="submit">

                        Simpan Perubahan

                    </x-form.input.button>

                </div>

            </form>

        </x-common.component-card>

    </div>

</div>

@endsection