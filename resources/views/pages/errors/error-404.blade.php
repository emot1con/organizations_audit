@extends('layouts.fullscreen-layout')

@section('content')
@php
    $currentYear = date('Y');
@endphp
  <div class="relative flex flex-col items-center justify-center min-h-screen p-6 overflow-hidden z-1">
      {{-- common grid shape --}}
      <x-common.common-grid-shape />
      <!-- Centered Content -->
      <div class="mx-auto flex w-full max-w-[472px] flex-col items-center text-center">
          <h1 class="mb-8 mt-8 font-bold text-gray-800 text-title-md dark:text-white/90 xl:text-title-2xl">
              ERROR
          </h1>

          <img src="/images/error/404.svg" alt="404" class="dark:hidden" />
          <img src="/images/error/404-dark.svg" alt="404" class="hidden dark:block" />

          <p class="mt-10 mb-6 text-base text-gray-700 dark:text-gray-400 sm:text-lg">
              Halaman yang anda cari tidak ada atau masih dalam pengembangan!
          </p>

          <a href="/"
              class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
              Back to Home Page
          </a>
      </div>
      <!-- Footer -->
      <p class="absolute bottom-6 left-0 w-full text-center text-sm text-gray-500 dark:text-gray-400">
          &copy; {{ $currentYear }} - TailAdmin
      </p>
  </div>
@endsection