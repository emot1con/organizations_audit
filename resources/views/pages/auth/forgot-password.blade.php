@extends('layouts.fullscreen-layout')

@section('title', 'Forgot Password')

@section('content')
@php
    $currentYear = date('Y');
@endphp

<div class="relative flex flex-col items-center justify-center min-h-screen p-6 overflow-hidden z-1">

    <x-common.common-grid-shape />

    <div class="mx-auto flex w-full max-w-[550px] flex-col items-center text-center">

        <h1 class="mb-4 mt-8 font-bold text-gray-800 text-title-md dark:text-white/90 xl:text-title-2xl">
            Lupa Password
        </h1>

        <div
            class="mb-8 flex h-28 w-28 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-14 w-14 text-green-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M8 10V7a4 4 0 118 0v3m-9 0h10a1 1 0 011 1v8a1 1 0 01-1 1H7a1 1 0 01-1-1v-8a1 1 0 011-1z"
                />
            </svg>
        </div>

        <p class="mb-6 text-base text-gray-700 dark:text-gray-400 sm:text-lg">
            Untuk melakukan reset password, silakan hubungi administrator melalui WhatsApp
            dengan format berikut:
        </p>

        <div
            class="w-full rounded-2xl border border-gray-200 bg-white p-6 text-left shadow-sm dark:border-gray-800 dark:bg-gray-900"
        >
<pre class="whitespace-pre-wrap text-sm text-gray-700 dark:text-gray-300">
Nama :
NPM :
Prodi :
Foto :
KTM :
</pre>
        </div>

        <a
            href="https://wa.me/6281278817837?text=Halo%20Admin,%20saya%20ingin%20melakukan%20reset%20password.%0A%0ANama%20:%20%0ANPM%20:%20%0AProdi%20:%20%0AFoto%20:%20%0AKTM%20:%20"
            target="_blank"
            class="mt-6 inline-flex items-center justify-center rounded-lg bg-green-500 px-6 py-3 text-sm font-medium text-white transition hover:bg-green-600"
        >
            Hubungi Admin via WhatsApp
        </a>

        <a
            href="{{ route('login') }}"
            class="mt-3 inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
        >
            Kembali ke Login
        </a>

    </div>

</div>
@endsection