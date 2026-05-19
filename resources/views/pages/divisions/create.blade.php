@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Buat Divisi" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Masukkan Data Divisi">

            {{-- Badge --}}
            <div class="mb-6 flex items-center gap-3">

                <span
                    class="rounded-full bg-blue-100 px-4 py-1 text-sm font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-300">

                    Divisi Organisasi

                </span>

            </div>

            {{-- FORM --}}
            <form
                action="{{ route('organizations.divisions.store', $organization) }}"
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

                {{-- Nama Divisi --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama Divisi"
                    type="text"
                    name="name"
                    placeholder="Masukkan nama divisi"
                    value="{{ old('name') }}"
                />

                @error('name')

                    <p class="mb-5 text-sm text-red-500">
                        {{ $message }}
                    </p>

                @enderror

                {{-- Category --}}
                <x-form.input.select
                    class="mb-5"
                    label="Kategori Divisi"
                    name="category"
                    placeholder="Pilih kategori divisi"
                    :selected="old('category')"
                    :options="[
                        'tetap' => 'Divisi Tetap',
                        'sementara' => 'Divisi Sementara',
                    ]"
                />

                @error('category')

                    <p class="mb-5 text-sm text-red-500">
                        {{ $message }}
                    </p>

                @enderror

                {{-- Division Cash --}}
                <x-form.input.input
                    class="mb-5"
                    label="Kas Divisi"
                    type="number"
                    name="division_cash"
                    value="0"
                    disabled="true"
                />

                {{-- Informasi --}}
                <div
                    class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-700 dark:border-blue-800 dark:bg-blue-900/20 dark:text-blue-300">

                    Divisi baru akan otomatis terhubung dengan organisasi
                    <span class="font-semibold">
                        {{ $organization->name }}
                    </span>
                    dan memiliki saldo awal Rp 0.

                </div>

                {{-- Button --}}
                <div class="flex justify-end gap-3">

                    <a
                        href="{{ url()->previous() }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition"
                    >

                        Back
                    </a>

                    <x-form.input.button type="submit">

                        Buat Divisi

                    </x-form.input.button>

                </div>

            </form>

        </x-common.component-card>

    </div>

</div>

@endsection