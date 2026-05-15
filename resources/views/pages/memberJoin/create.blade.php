@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Enroll Organization" />

<div class="grid grid-cols-1 gap-6">

    <div class="space-y-6">

        <x-common.component-card title="Masuk Ke Organisasi">


            {{-- FORM --}}
            {{-- <form
                action="{{ route('organizations.join.store', $organization) }}"
                method="POST"
            > --}}

                @csrf

                {{-- Nama Organisasi --}}
                <x-form.input.input
                    class="mb-5"
                    label="Nama Organisasi"
                    type="text"
                    name="organization_name"
                    value="Himpunan Mahasiswa Informatika"
                    disabled="true"
                />

                {{-- Password Organization --}}
                <x-form.input.input
                    class="mb-5"
                    label="Kode Organisasi"
                    type="password"
                    name="password_organization"
                    placeholder="Masukkan kode organisasi"
                />

                {{-- Informasi --}}
                <div
                    class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300">

                    Masukkan kode organisasi yang diberikan untuk dapat bergabung ke dalam organisasi.

                </div>

                {{-- Button --}}
                <div class="flex justify-end">

                    <x-form.input.button type="submit">

                        Enroll

                    </x-form.input.button>

                </div>

            </form>

        </x-common.component-card>

    </div>

</div>

@endsection