@extends('layouts.app')

@section('content')

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Edit Profile">

            <form
                action="{{ route('profile.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')

                {{-- Preview Photo --}}
                <div class="mb-5">

                    <label
                        class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
                    >

                        Preview Profile

                    </label>

                    <div class="flex items-center gap-4">

                        <img
                            src="{{ auth()->user()->photo
                                ? asset('storage/' . auth()->user()->photo)
                                : 'https://placehold.co/100x100'
                            }}"
                            class="h-20 w-20 rounded-full border border-gray-200 object-cover dark:border-gray-700"
                        >

                        {{-- @if(auth()->user()->photo)

                            <label class="flex items-center gap-2">

                                <input
                                    type="checkbox"
                                    name="remove_photo"
                                    value="1"
                                    class="rounded border-gray-300 text-red-500 focus:ring-red-500"
                                >

                                <span
                                    class="text-sm text-red-500"
                                >

                                    Hapus Foto

                                </span>

                            </label>

                        @endif --}}

                    </div>

                </div>

                {{-- Upload Photo --}}
                <x-form.input.file
                    class="mb-5"
                    label="Foto Profile"
                    name="photo"
                    accept="image/*"
                />

                {{-- Name --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama"
                    type="text"
                    name="name"
                    placeholder="Masukkan nama"
                    value="{{ old('name', auth()->user()->name) }}"
                />

                {{-- Email --}}
                <x-form.input.input
                    class="mb-5"
                    label="Email"
                    type="email"
                    name="email"
                    placeholder="Masukkan email"
                    value="{{ old('email', auth()->user()->email) }}"
                />

                {{-- Current Password --}}
                <x-form.input.input
                    class="mb-5"
                    label="Password Saat Ini"
                    type="password"
                    name="current_password"
                    placeholder="Masukkan password saat ini"
                />

                {{-- New Password --}}
                <x-form.input.input
                    class="mb-5"
                    label="Password Baru"
                    type="password"
                    name="password"
                    placeholder="Masukkan password baru"
                />

                {{-- Confirm Password --}}
                <x-form.input.input
                    class="mb-5"
                    label="Konfirmasi Password"
                    type="password"
                    name="password_confirmation"
                    placeholder="Konfirmasi password baru"
                />

                {{-- Submit --}}
                <div class="flex justify-end">

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
                    >

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </x-common.component-card>

    </div>

</div>

@endsection