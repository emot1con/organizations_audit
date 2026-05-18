@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Transactions" />

<div class="space-y-6">

    {{-- Header --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-start justify-between flex-wrap gap-5">

            <div>

                @if ($type === 'organization')

                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $organization->name }}
                    </h1>

                    <p class="mt-3 text-gray-500 dark:text-gray-400">
                        Seluruh transaksi organisasi dan request dana divisi.
                    </p>

                @else

                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $division->name }}
                    </h1>

                    <p class="mt-3 text-gray-500 dark:text-gray-400">
                        Riwayat transaksi dan request divisi.
                    </p>

                @endif

            </div>

            {{-- Action --}}
            <div>

                @if ($type === 'organization')

                    <a href="{{ route('organizations.transactions.create', $organization) }}"
                        class="inline-flex items-center justify-center rounded-xl bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition">

                        Tambah Transaksi

                    </a>

                @else

                    <a href="{{ route('divisions.transactions.create', $division) }}"
                        class="inline-flex items-center justify-center rounded-xl bg-orange-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-orange-600 transition">

                        Tambah Transaksi

                    </a>

                @endif

            </div>

        </div>

    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="border-b border-gray-100 dark:border-gray-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                            ID
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                            Category
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                            Nominal
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                            Divisi
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                            Dibuat Oleh
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-500 dark:text-gray-400">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-500 dark:text-gray-400">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($transactions as $transaction)

                        <tr class="border-b border-gray-100 dark:border-gray-800">

                            {{-- ID --}}
                            <td class="px-6 py-5 text-sm text-gray-700 dark:text-gray-300">

                                #TRX-{{ str_pad($transaction->id, 3, '0', STR_PAD_LEFT) }}

                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-5">

                                @php

                                    $categoryColor = match($transaction->category) {

                                        'pengeluaran' =>
                                            'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300',

                                        default =>
                                            'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300',

                                    };

                                @endphp

                                <span
                                    class="rounded-full px-3 py-1 text-xs font-medium {{ $categoryColor }}">

                                    {{ ucfirst($transaction->category) }}

                                </span>

                            </td>

                            {{-- Amount --}}
                            <td class="px-6 py-5 text-sm font-semibold text-gray-800 dark:text-white">

                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}

                            </td>

                            {{-- Division --}}
                            <td class="px-6 py-5 text-sm text-gray-700 dark:text-gray-300">

                                @if($transaction->division_id)

                                    {{ $transaction->division?->name }}

                                @else

                                    -

                                @endif

                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5">

                                @php

                                    $statusColor = match($transaction->status) {

                                        'approved' =>
                                            'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300',

                                        'rejected' =>
                                            'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300',

                                        default =>
                                            'bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300',

                                    };

                                @endphp

                                <span
                                    class="rounded-full px-3 py-1 text-xs font-medium {{ $statusColor }}">

                                    {{ ucfirst($transaction->status) }}

                                </span>

                            </td>

                            {{-- Created By --}}
                            <td class="px-6 py-5 text-sm text-gray-700 dark:text-gray-300">

                                {{ $transaction->createdBy?->name ?? '-' }}

                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">

                                {{ $transaction->transaction_date?->translatedFormat('d F Y') }}

                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-5">

                                <div class="flex justify-end gap-2">

                                    @if(
                                        $type === 'organization' &&
                                        $transaction->status === 'pending'
                                    )

                                        <button
                                            class="rounded-lg bg-green-500 px-3 py-2 text-xs font-medium text-white hover:bg-green-600">

                                            Approve

                                        </button>

                                        <button
                                            class="rounded-lg bg-red-500 px-3 py-2 text-xs font-medium text-white hover:bg-red-600">

                                            Tolak

                                        </button>

                                    @endif

                                    @if ($type === 'organization')

                                        <a href="{{ route('organizations.transactions.show', [$organization, $transaction]) }}"
                                            class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">

                                            Detail

                                        </a>

                                    @else

                                        <a href="{{ route('divisions.transactions.show', [$division, $transaction]) }}"
                                            class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">

                                            Detail

                                        </a>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="px-6 py-10 text-center">

                                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">
                                    Belum ada transaksi
                                </h3>

                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Transaksi belum tersedia.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection