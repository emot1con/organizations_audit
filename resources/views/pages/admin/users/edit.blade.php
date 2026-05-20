@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">

            Edit User

        </h1>

        <p class="mt-2 text-gray-500 dark:text-gray-400">

            Kelola data user dan role.

        </p>

    </div>

    {{-- Form --}}
    <div
        class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]"
    >

        <form
            action="{{ route('admin.users.update', $user) }}"
            method="POST"
            class="space-y-5"
        >

            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>

                <label
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >

                    Nama

                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="h-11 w-full rounded-xl border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:text-white"
                >

                @error('name')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Role --}}
            <div>

                <label
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >

                    Role

                </label>

                <select
                    name="role_id"
                    class="h-11 w-full rounded-xl border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                >

                    @foreach($roles as $role)

                        <option
                            value="{{ $role->id }}"
                            @selected($user->role_id == $role->id)
                        >

                            {{ ucfirst($role->name) }}

                        </option>

                    @endforeach

                </select>

                @error('role_id')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Password --}}
            <div>

                <label
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >

                    Password Baru

                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Kosongkan jika tidak ingin mengubah password"
                    class="h-11 w-full rounded-xl border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:text-white"
                >

                @error('password')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 pt-4">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                >

                    Batal

                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-brand-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-brand-600"
                >

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection