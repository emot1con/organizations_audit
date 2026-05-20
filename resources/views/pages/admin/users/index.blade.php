@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">

            Manage Users

        </h1>

        <p class="mt-2 text-gray-500 dark:text-gray-400">

            Seluruh user yang terdaftar di sistem.

        </p>

    </div>

    {{-- Table --}}
    <div
        class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
    >

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead
                    class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900"
                >

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                            User
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Role
                        </th>

                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr
                            class="border-b border-gray-100 dark:border-gray-800"
                        >

                            {{-- User --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    @if($user->photo)

                                        <img
                                            src="{{ asset('storage/' . $user->photo) }}"
                                            class="h-12 w-12 rounded-full object-cover"
                                        >

                                    @else

                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-500 font-semibold text-white"
                                        >

                                            {{ strtoupper(substr($user->name, 0, 1)) }}

                                        </div>

                                    @endif

                                    <div>

                                        <h3 class="font-semibold text-gray-800 dark:text-white">

                                            {{ $user->name }}

                                        </h3>

                                    </div>

                                </div>

                            </td>

                            {{-- Email --}}
                            <td class="px-6 py-5 text-sm text-gray-600 dark:text-gray-300">

                                {{ $user->email }}

                            </td>

                            {{-- Role --}}
                            <td class="px-6 py-5">

                                <span
                                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-300"
                                >

                                    {{ $user->role?->name ?? 'user' }}

                                </span>

                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-5">

                                <div class="flex justify-end gap-3">

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.users.edit', $user) }}"
                                        class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-600 transition hover:border-blue-300 hover:bg-blue-100 dark:border-blue-900/40 dark:bg-blue-900/10 dark:text-blue-300 dark:hover:bg-blue-900/20"
                                    >

                                        Edit

                                    </a>

                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('admin.users.destroy', $user) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus user ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-600 transition hover:border-red-300 hover:bg-red-100 dark:border-red-900/40 dark:bg-red-900/10 dark:text-red-300 dark:hover:bg-red-900/20"
                                        >

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="px-6 py-10 text-center text-gray-500 dark:text-gray-400"
                            >

                                Belum ada user.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection