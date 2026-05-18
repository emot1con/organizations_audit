@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Edit Organisasi" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Edit Data Organisasi">

            <form
                action="{{ route('organizations.update', $organization) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                {{-- Nama Organisasi --}}
                <x-form.input.input 
                    class="mb-5"
                    label="Nama Organisasi"
                    type="text"
                    name="name"
                    placeholder="Masukkan nama organisasi"
                    value="{{ old('name', $organization->name) }}"
                />

                @error('name')

                    <p class="mb-5 text-sm text-red-500">
                        {{ $message }}
                    </p>

                @enderror

                {{-- Uang Organisasi --}}
                <x-form.input.input
                    class="mb-5"
                    label="Uang Organisasi"
                    type="number"
                    name="organizations_cash"
                    placeholder="Masukkan Total Keuangan Organisasi"
                    disabled=true
                    value="{{ old('organizations_cash', $organization->organizations_cash) }}"
                />

               

                {{-- Kategori --}}
                <x-form.input.select
                    class="mb-5"
                    label="Kategori Organisasi"
                    name="category_organizations"
                    placeholder="Pilih kategori organisasi"
                    :selected="old(
                        'category_organizations',
                        $organization->category_organizations
                    )"
                    :options="[
                        'Himpunan' => 'Himpunan',
                        'BEM' => 'BEM',
                        'UKM' => 'UKM',
                    ]"
                />

                @error('category_organizations')

                    <p class="mb-5 text-sm text-red-500">
                        {{ $message }}
                    </p>

                @enderror

                {{-- Kode Join --}}
                <x-form.input.input
                    class="mb-5"
                    label="Kode Join Organisasi"
                    type="text"
                    name="password_organizations"
                    placeholder="Masukkan Kode Untuk verifikasi User Join (Isi hanya jika ingin diubah)"
                    value="" 
                />

                @error('password_organizations')

                    <p class="mb-5 text-sm text-red-500">
                        {{ $message }}
                    </p>

                @enderror

                {{-- Email --}}
                <x-form.input.input
                    class="mb-5"
                    label="Email Organisasi"
                    type="email"
                    name="contact"
                    placeholder="Masukkan Email Organisasi"
                    value="{{ old('contact', $organization->contact) }}"
                />

                @error('contact')

                    <p class="mb-5 text-sm text-red-500">
                        {{ $message }}
                    </p>

                @enderror

                {{-- Deskripsi --}}
                <x-form.input.text-area
                    class="mb-5"
                    label="Deskripsi Organisasi"
                    name="description"
                    placeholder="Masukkan Deskripsi Organisasi"
                    rows="4"
                >{{ old('description', $organization->description) }}</x-form.input.text-area>

                @error('description')

                    <p class="mb-5 text-sm text-red-500">
                        {{ $message }}
                    </p>

                @enderror

                {{-- Information --}}
                <div
                    class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-700 dark:border-blue-800 dark:bg-blue-900/20 dark:text-blue-300">

                    Perubahan data organisasi akan langsung diperbarui dan terlihat oleh seluruh anggota organisasi.

                </div>

                {{-- Button --}}
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('organizations.settings.index', $organization) }}"
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