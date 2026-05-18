@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Buat Transaksi" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Masukkan Data Transaksi">

            {{-- Badge Information --}}
            <div class="mb-6 flex items-center gap-3">

                @if ($type === 'organization')

                    <span
                        class="rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-600 dark:bg-green-900 dark:text-green-300">

                        Saldo Organisasi :
                        Rp {{ number_format($organization->organizations_cash, 0, ',', '.') }}

                    </span>

                @else

                    <span
                        class="rounded-full bg-orange-100 px-4 py-1 text-sm font-medium text-orange-600 dark:bg-orange-900 dark:text-orange-300">

                        Saldo Divisi :
                        Rp {{ number_format($division->division_cash, 0, ',', '.') }}

                    </span>

                @endif

            </div>

            {{-- FORM --}}
            @if ($type === 'organization')

                <form
                    action="{{ route('organizations.transactions.store', $organization) }}"
                    method="POST"
                >

            @else

                <form
                    action="{{ route('divisions.transactions.store', $division) }}"
                    method="POST"
                >

            @endif

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
                @if ($type === 'division')

                    <x-form.input.input
                        class="mb-5"
                        label="Nama Divisi"
                        type="text"
                        name="division_name"
                        value="{{ $division->name }}"
                        disabled="true"
                    />

                @endif

                {{-- Nama Pengaju --}}
                <x-form.input.input
                    class="mb-5"
                    label="Diajukan Oleh"
                    type="text"
                    name="created_by"
                    value="{{ auth()->user()->name }}"
                    disabled="true"
                />

                {{-- Category --}}
                @if ($type === 'organization')

                    <x-form.input.select
                        class="mb-5"
                        label="Kategori Transaksi"
                        name="category"
                        placeholder="Pilih kategori transaksi"
                        :selected="old('category')"
                        :options="[
                            'pemasukan' => 'Pemasukan',
                            'pengeluaran' => 'Pengeluaran',
                        ]"
                    />

                @else

                    <x-form.input.select
                        class="mb-5"
                        label="Kategori Transaksi"
                        name="category"
                        placeholder="Pilih kategori transaksi"
                        :selected="old('category')"
                        :options="[
                            'pengeluaran' => 'Pengeluaran',
                            'pemasukan_organisasi' => 'Pemasukan Dari Organisasi',
                            'pemasukan_lainnya' => 'Pemasukan Dari Lainnya',
                        ]"
                    />

                @endif

                @error('category')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

                {{-- Nominal --}}
                <x-form.input.input
                    class="mb-2"
                    label="Nominal Transaksi"
                    type="number"
                    name="amount"
                    placeholder="Masukkan nominal transaksi"
                    value="{{ old('amount') }}"
                />

                @error('amount')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

                {{-- Tanggal --}}
                <div class="mb-5">

                    <label
                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">

                        Tanggal Transaksi

                    </label>

                    <x-form.date-picker
                        id="transaction_date"
                        name="transaction_date"
                        placeholder="Pilih tanggal transaksi"
                        defaultDate="{{ old('transaction_date', now()->format('Y-m-d')) }}"
                    />

                </div>

                {{-- Upload Bukti --}}
                <x-form.input.input
                    class="mb-2"
                    label="Upload Bukti"
                    type="url"
                    placeholder="Masukkan URL bukti transaksi"
                    name="proof_url"
                    value="{{ old('proof_url') }}"
                />

                @error('proof_url')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

                {{-- Deskripsi --}}
                <x-form.input.text-area
                    class="mb-2"
                    label="Deskripsi Transaksi"
                    name="description"
                    placeholder="Masukkan deskripsi transaksi"
                    rows="5"
                >{{ old('description') }}</x-form.input.text-area>

                @error('description')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

                {{-- Informasi --}}
                @if ($type === 'organization')

                    <div
                        class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300">

                        Transaksi organisasi akan langsung diproses dan masuk ke saldo organisasi.

                    </div>

                @else

                    <div
                        class="mb-6 rounded-2xl border border-orange-200 bg-orange-50 p-4 text-sm text-orange-700 dark:border-orange-800 dark:bg-orange-900/20 dark:text-orange-300">

                        Pengeluaran dan pemasukan dari organisasi membutuhkan approval organisasi.

                    </div>

                @endif

                {{-- Button --}}
                <div class="flex justify-end">

                    <x-form.input.button type="submit">

                        @if ($type === 'organization')

                            Simpan Transaksi

                        @else

                            Kirim Transaksi

                        @endif

                    </x-form.input.button>

                </div>

            </form>

        </x-common.component-card>

    </div>

</div>

@endsection