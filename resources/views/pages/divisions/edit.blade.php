@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Edit Divisi" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Edit Data Divisi">

            <form
                action="{{ route('divisions.update', $division) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                {{-- Nama Organization --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama Organisasi"
                    type="text"
                    value="{{ $organization->name }}"
                    disabled=true
                />

                {{-- Nama Divisi --}}
                <x-form.input.input 
                    class="mb-5"
                    label="Nama Divisi"
                    type="text"
                    name="name"
                    placeholder="Masukkan nama divisi"
                    value="{{ old('name', $division->name) }}"
                />

                @error('name')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

                {{-- Saldo Divisi --}}
                <x-form.input.input
                    class="mb-5"
                    label="Saldo Divisi"
                    type="number"
                    value="{{ old('division_cash', $division->division_cash) }}"
                    disabled=true
                />

                {{-- Kategori Divisi --}}
                <x-form.input.select
                    class="mb-5"
                    label="Kategori Divisi"
                    name="category"
                    placeholder="Pilih kategori divisi"
                    :selected="old(
                        'category',
                        $division->category
                    )"
                    :options="[
                        'tetap' => 'Tetap',
                        'sementara' => 'Sementara',
                    ]"
                />

                @error('category_divisions')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

                {{-- Information --}}
                <div
                    class="mb-6 rounded-2xl border border-orange-200 bg-orange-50 p-4 text-sm text-orange-700 dark:border-orange-800 dark:bg-orange-900/20 dark:text-orange-300">

                    Perubahan data divisi akan langsung diperbarui dan terlihat oleh seluruh anggota divisi.

                </div>

                {{-- Button --}}
                <div class="flex items-center justify-end gap-3">

                    <a
                        href="{{ route('divisions.settings', $division) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] transition">

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