@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Detail Transaksi" />

<div class="space-y-6">

    {{-- Header --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-start justify-between flex-wrap gap-5">

            <div>

                @if ($type === 'organization')

                    <div class="mb-3">

                        <span
                            class="rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-600 dark:bg-green-900 dark:text-green-300">

                            Organization Transaction

                        </span>

                    </div>

                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $organization->name }}
                    </h1>

                    <p class="mt-3 text-gray-500 dark:text-gray-400">
                        Detail transaksi organisasi.
                    </p>

                @else

                    <div class="mb-3">

                        <span
                            class="rounded-full bg-orange-100 px-4 py-1 text-sm font-medium text-orange-600 dark:bg-orange-900 dark:text-orange-300">

                            Division Transaction

                        </span>

                    </div>

                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                        Divisi Media Kreatif
                    </h1>

                    <p class="mt-3 text-gray-500 dark:text-gray-400">
                        Detail request transaksi divisi.
                    </p>

                @endif

            </div>

            {{-- Status --}}
            <div>

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
                class="rounded-full px-4 py-2 text-sm font-medium {{ $statusColor }}">

                {{ ucfirst($transaction->status) }}

            </span>

            </div>

        </div>

    </div>

    {{-- Detail --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Main Detail --}}
        <div class="xl:col-span-2">

            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

                <h2 class="mb-6 text-2xl font-bold text-gray-800 dark:text-white">

                    Informasi Transaksi

                </h2>

                <div class="space-y-6">

                    {{-- ID --}}
                    <div>

                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">
                            ID Transaksi
                        </p>

                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            #TRX-{{ str_pad($transaction->id, 3, '0', STR_PAD_LEFT) }}
                        </h3>

                    </div>

                    {{-- Type --}}
                    <div>

                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">
                            Tipe Transaksi
                        </p>

                        <span
                            class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-600 dark:bg-red-900 dark:text-red-300">

                            {{ ucfirst($transaction->category) }}

                        </span>

                    </div>

                    {{-- Amount --}}
                    <div>

                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">
                            Nominal
                        </p>

                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </h3>

                    </div>

                    {{-- Division --}}
                    <div>

                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">
                            Divisi
                        </p>

                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            @if($transaction->division_id)

                                {{ $transaction->division?->name }}

                            @else

                                -

                            @endif
                        </h3>

                    </div>

                    {{-- Date --}}
                    <div>

                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">
                            Tanggal Transaksi
                        </p>

                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            {{ $transaction->transaction_date?->translatedFormat('d F Y') }}
                        </h3>

                    </div>

                    {{-- Description --}}
                    <div>

                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">
                            Deskripsi
                        </p>

                        <div
                            class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">

                            {{ $transaction->description }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Approval --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

                <h2 class="mb-5 text-xl font-bold text-gray-800 dark:text-white">

                    Approval

                </h2>

                <div class="space-y-4">

                    <div>

                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">
                            Diajukan Oleh
                        </p>

                        <h3 class="font-semibold text-gray-800 dark:text-white">
                            {{ $transaction->createdBy?->name }}
                        </h3>

                    </div>

                    <div>

                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">
                            Approved By
                        </p>

                        <h3 class="font-semibold text-gray-800 dark:text-white">
                            {{ $transaction->approvedBy?->name ?? 'Belum disetujui' }}
                        </h3>

                    </div>

                </div>

            </div>

            {{-- Proof --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

                <h2 class="mb-5 text-xl font-bold text-gray-800 dark:text-white">

                    Bukti Transaksi

                </h2>

                <span>
                    {{ $transaction->proof_url }}
                </span>

            </div>

            {{-- Actions --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

                <h2 class="mb-5 text-xl font-bold text-gray-800 dark:text-white">

                    Actions

                </h2>

                <div class="flex flex-col gap-3">

                    <button
                        class="rounded-xl bg-green-500 px-5 py-3 text-sm font-medium text-white hover:bg-green-600 transition">

                        Approve

                    </button>

                    <button
                        class="rounded-xl bg-red-500 px-5 py-3 text-sm font-medium text-white hover:bg-red-600 transition">

                        Tolak

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection