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
                        Himpunan Mahasiswa Informatika
                    </h1>

                    <p class="mt-3 text-gray-500 dark:text-gray-400">
                        Seluruh transaksi organisasi dan request dana divisi.
                    </p>

                @else

                   

                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                        Divisi Media Kreatif
                    </h1>

                    <p class="mt-3 text-gray-500 dark:text-gray-400">
                        Riwayat transaksi dan request divisi.
                    </p>

                @endif

            </div>

            {{-- Action --}}
            <div>

                @if ($type === 'organization')

                    <a href="#"
                        class="inline-flex items-center justify-center rounded-xl bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition">

                        Tambah Transaksi

                    </a>

                @else

                    <a href="#"
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
                            Tipe
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
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-500 dark:text-gray-400">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    {{-- Row 1 --}}
                    <tr class="border-b border-gray-100 dark:border-gray-800">

                        <td class="px-6 py-5 text-sm text-gray-700 dark:text-gray-300">
                            #TRX-001
                        </td>

                        <td class="px-6 py-5">

                            <span
                                class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-600 dark:bg-red-900 dark:text-red-300">

                                Pengeluaran

                            </span>

                        </td>

                        <td class="px-6 py-5 text-sm font-semibold text-gray-800 dark:text-white">
                            Rp 500.000
                        </td>

                        <td class="px-6 py-5 text-sm text-gray-700 dark:text-gray-300">
                            Divisi Media Kreatif
                        </td>

                        <td class="px-6 py-5">

                            <span
                                class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300">

                                Pending

                            </span>

                        </td>

                        <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">
                            15 Mei 2026
                        </td>

                        
                            
                        
                        <td class="px-6 py-5">

                            <div class="flex justify-end gap-2">

                            @if ($type !== 'division')
                                <button
                                    class="rounded-lg bg-green-500 px-3 py-2 text-xs font-medium text-white hover:bg-green-600">

                                    Approve

                                </button>

                                <button
                                    class="rounded-lg bg-red-500 px-3 py-2 text-xs font-medium text-white hover:bg-red-600">

                                    Tolak

                                </button>
                           
                                <a href="{{ route('divisions.transactions.show', [4, 1]) }}" 
                                    class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">

                                    Detail

                                </a>

                             @endif

                                <a href="{{ route('organizations.transactions.show', [4, 1]) }}" 
                                    class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">

                                    Detail

                                </a>

                            </div>

                        </td>

                    </tr>

                    {{-- Row 2 --}}
                    <tr class="border-b border-gray-100 dark:border-gray-800">

                        <td class="px-6 py-5 text-sm text-gray-700 dark:text-gray-300">
                            #TRX-002
                        </td>

                        <td class="px-6 py-5">

                            <span
                                class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-600 dark:bg-green-900 dark:text-green-300">

                                Pendapatan

                            </span>

                        </td>

                        <td class="px-6 py-5 text-sm font-semibold text-gray-800 dark:text-white">
                            Rp 1.200.000
                        </td>

                        <td class="px-6 py-5 text-sm text-gray-700 dark:text-gray-300">
                            Organisasi
                        </td>

                        <td class="px-6 py-5">

                            <span
                                class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-600 dark:bg-green-900 dark:text-green-300">

                                Approved

                            </span>

                        </td>

                        <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">
                            17 Mei 2026
                        </td>

                        <td class="px-6 py-5">

                            <div class="flex justify-end">

                                <a href="#"
                                    class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">

                                    Detail

                                </a>

                            </div>

                        </td>

                    </tr>

                    {{-- Row 3 --}}
                    <tr>

                        <td class="px-6 py-5 text-sm text-gray-700 dark:text-gray-300">
                            #TRX-003
                        </td>

                        <td class="px-6 py-5">

                            <span
                                class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-600 dark:bg-red-900 dark:text-red-300">

                                Pengeluaran

                            </span>

                        </td>

                        <td class="px-6 py-5 text-sm font-semibold text-gray-800 dark:text-white">
                            Rp 300.000
                        </td>

                        <td class="px-6 py-5 text-sm text-gray-700 dark:text-gray-300">
                            Divisi Acara
                        </td>

                        <td class="px-6 py-5">

                            <span
                                class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-600 dark:bg-red-900 dark:text-red-300">

                                Rejected

                            </span>

                        </td>

                        <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">
                            19 Mei 2026
                        </td>

                        <td class="px-6 py-5">

                            <div class="flex justify-end">

                                <a href="#"
                                    class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">

                                    Detail

                                </a>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection