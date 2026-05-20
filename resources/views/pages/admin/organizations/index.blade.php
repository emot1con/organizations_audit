@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">

            Manage Organizations

        </h1>

        <p class="mt-2 text-gray-500 dark:text-gray-400">

            Seluruh organisasi yang terdaftar di sistem.

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
                            Organization
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Members
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Category
                        </th>

                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($organizations as $organization)

                        <tr
                            class="border-b border-gray-100 dark:border-gray-800"
                        >

                            {{-- Organization --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <img
                                        src="{{ $organization->photo
                                            ? asset('storage/' . $organization->photo)
                                            : 'https://placehold.co/100x100'
                                        }}"
                                        class="h-12 w-12 rounded-xl object-cover"
                                    >

                                    <div>

                                        <h3 class="font-semibold text-gray-800 dark:text-white">

                                            {{ $organization->name }}

                                        </h3>

                                        <p class="text-sm text-gray-500 dark:text-gray-400">

                                            {{ $organization->contact }}

                                        </p>

                                    </div>

                                </div>

                            </td>

                            {{-- Members --}}
                            <td class="px-6 py-5 text-sm text-gray-600 dark:text-gray-300">

                                {{ $organization->total_members }}

                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-5">

                                <span
                                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-300"
                                >

                                    {{ $organization->category_organizations }}

                                </span>

                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-5">

                                <div class="flex justify-end">

                                    <form
                                        action="{{ route('admin.organizations.destroy', $organization) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus organisasi ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-xl bg-red-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-600"
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

                                Belum ada organisasi.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection 