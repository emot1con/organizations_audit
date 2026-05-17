@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Edit Organisasi" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Edit Data Organisasi">

            <form action="{{ route('organizations.update', $organization) }}" method="POST">

                @csrf
                @method('PUT')

                {{-- Nama Organisasi --}}
                <x-form.input.input 
                    class="mb-5"
                    label="Nama Organisasi"
                    type="text"
                    name="name"
                    placeholder="Masukkan nama organisasi"
                    value="Himpunan Mahasiswa Informatika"
                />

                {{-- Uang Organisasi --}}
                <x-form.input.input
                    class="mb-5"
                    label="Uang Organisasi"
                    type="number"
                    name="organizations_cash"
                    placeholder="Masukkan Total Keuangan Organisasi"
                    value="2500000"
                />

                {{-- Kategori --}}
                <x-form.input.select
                    class="mb-5"
                    label="Kategori Organisasi"
                    name="category"
                    placeholder="Pilih kategori organisasi"
                    selected="1"
                    :options="[
                        '1' => 'Himpunan',
                        '2' => 'BEM',
                        '3' => 'UKM',
                    ]"
                />

                {{-- Kode Join --}}
                <x-form.input.input
                    class="mb-5"
                    label="Kode Join Organisasi"
                    type="text"
                    name="password_organization"
                    placeholder="Masukkan Kode Untuk verifikasi User Join"
                    value="HMIF2026"
                />

                {{-- Email --}}
                <x-form.input.input
                    class="mb-5"
                    label="Email Organisasi"
                    type="email"
                    name="contact"
                    placeholder="Masukkan Email Organisasi"
                    value="hmif@gmail.com"
                />

                {{-- Deskripsi --}}
                <x-form.input.text-area
                    class="mb-5"
                    label="Deskripsi Organisasi"
                    name="description"
                    placeholder="Masukkan Deskripsi Organisasi"
                    rows="4"
                >Himpunan Mahasiswa Informatika merupakan organisasi mahasiswa yang bergerak di bidang akademik dan pengembangan teknologi.
                </x-form.input.text-area>

                {{-- Information --}}
                <div
                    class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-700 dark:border-blue-800 dark:bg-blue-900/20 dark:text-blue-300">

                    Perubahan data organisasi akan langsung diperbarui dan terlihat oleh seluruh anggota organisasi.

                </div>

                {{-- Button --}}
                <div class="flex items-center justify-end gap-3">

                    <a href="#"
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