@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Buat Organisasi" />
    
    <div class="grid grid-cols-1 gap-6">
        <div class="space-y-6">

            <x-common.component-card title="Masukkan Data Organiasi">
                
                <form action="/organizations" method="POST" enctype="multipart/form-data">
                    @csrf

                    <x-form.input.input 
                        class="mb-5"
                        label="Nama Organisasi"
                        type="text"
                        name="name"
                        placeholder="Masukkan nama organisasi"
                        value=""
                    />

                     @error('name')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                    @enderror

                    <x-form.input.input
                        class="mb-5"
                        label="Uang Organisasi"
                        type="number"
                        name="organizations_cash"
                        placeholder="Masukkan Total Keuangan Organisasi"
                        value=""
                    />

                     @error('organizations_cash')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                    @enderror

                    <x-form.input.select
                    class="mb-5"
                    label="Kategori Organisasi"
                    name="category_organizations"
                    placeholder="Pilih kategori organisasi"
                    :options="[
                        'Himpunan' => 'Himpunan',
                        'BEM' => 'BEM',
                        'UKM' => 'UKM',
                    ]"
                />

                 @error('category_organizations')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                    @enderror

                    <x-form.input.input
                        class="mb-5"
                        label="Kode Join Organisasi"
                        type="text"
                        name="password_organizations"
                        placeholder="Masukkan Kode Untuk verifikasi User Join"
                        value=""
                    />

                     @error('password_organizations')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                    @enderror

                    <x-form.input.input
                        class="mb-5"
                        label="Email Organisasi"
                        type="email"
                        name="contact"
                        placeholder="Masukkan Email Organisasi"
                        value=""
                    />

                    <x-form.input.file
                        class="mb-5"
                        label="Foto Organisasi"
                        name="photo"
                        accept="image/*"
                    />

                    @error('photo')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                    @enderror

                    <x-form.input.text-area
                        class="mb-3"
                        label="Deskripsi Organisasi"
                        name="description"
                        placeholder="Masukkan Deskripsi Organisasi"
                        rows="4"
                    />

                     @error('desciption')

                    <p class="mb-5 text-sm text-red-500">

                        {{ $message }}

                    </p>

                    @enderror

                    <x-form.input.button type="submit">
                        Buat
                    </x-form.input.button>

                </form>

            </x-common.component-card>

        </div>
    </div>
@endsection