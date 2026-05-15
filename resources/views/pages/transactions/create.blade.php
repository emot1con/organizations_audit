@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Buat Transaksi" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Masukkan Data Transaksi">

            {{-- Badge Information --}}
            <div class="mb-6 flex items-center gap-3">

                @if ($type == 'organization')

                    <span
                        class="rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-600 dark:bg-green-900 dark:text-green-300">

                        Transaksi Organisasi

                    </span>

                @else

                    <span
                        class="rounded-full bg-orange-100 px-4 py-1 text-sm font-medium text-orange-600 dark:bg-orange-900 dark:text-orange-300">

                        Request Transaksi Divisi

                    </span>

                @endif

            </div>

            {{-- FORM --}}
            @if ($type === 'organization')

                <form
                    action="{{ route('organizations.transactions.store', $organization) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

            @else

                <form
                    action="{{ route('divisions.transactions.store', $division) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

            @endif

                @csrf

                {{-- Nama Organisasi --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama Organisasi"
                    type="text"
                    name="organization_name"
                    value="Himpunan Mahasiswa Informatika"
                    disabled="true"
                />

                {{-- Nama Divisi --}}
                @if ($type == 'division')

                    <x-form.input.input
                        class="mb-5"
                        label="Nama Divisi"
                        type="text"
                        name="division_name"
                        value="Divisi Media Kreatif"
                        disabled="true"
                    />

                @endif

                {{-- Nama Pengaju --}}
                <x-form.input.input
                    class="mb-5"
                    label="Diajukan Oleh"
                    type="text"
                    name="created_by"
                    value="Deru Pratama"
                    disabled="true"
                />

                

                {{-- Tipe --}}
                <x-form.input.select
                    class="mb-5"
                    label="Kategori Transaksi"
                    name="category_id"
                    placeholder="Pilih kategori transaksi"
                    :options="[
                        '1' => 'Pemasukan',
                        '2' => 'Pengeluaran',
                    ]"
                />

                {{-- Nominal --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nominal Transaksi"
                    type="number"
                    name="amount"
                    placeholder="Masukkan nominal transaksi"
                    value=""
                />

                {{-- Tanggal --}}
                <div class="mb-5">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tanggal Transaksi
                    </label>

                    <x-form.date-picker
                        id="transaction_date"
                        name="transaction_date"
                        placeholder="Pilih tanggal transaksi"
                        defaultDate="{{ now()->format('Y-m-d') }}"
                    />
                </div>

                {{-- Upload Bukti --}}
                <x-form.input.input
                    class="mb-5"
                    label="Upload Bukti"
                    type="url"
                    placeholder="Masukkan URL bukti transaksi"
                    name="proof_url"
                />

                {{-- Deskripsi --}}
                <x-form.input.text-area
                    class="mb-5"
                    label="Deskripsi Transaksi"
                    name="description"
                    placeholder="Masukkan deskripsi transaksi"
                    rows="5"
                />

                {{-- Informasi --}}
                @if ($type == 'organization')

                    <div
                        class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300">

                        Transaksi organisasi akan langsung diproses dan masuk ke kas organisasi.

                    </div>

                @else

                    <div
                        class="mb-6 rounded-2xl border border-orange-200 bg-orange-50 p-4 text-sm text-orange-700 dark:border-orange-800 dark:bg-orange-900/20 dark:text-orange-300">

                        Request transaksi divisi harus menunggu persetujuan organisasi sebelum diproses.

                    </div>

                @endif

                {{-- Button --}}
                <div class="flex justify-end">

                    <x-form.input.button type="submit">

                        @if ($type == 'organization')

                            Simpan Transaksi

                        @else

                            Kirim Request

                        @endif

                    </x-form.input.button>

                </div>

            </form>

        </x-common.component-card>

    </div>

</div>

@endsection