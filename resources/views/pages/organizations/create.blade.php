@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Buat Organisasi" />
    
    <div class="grid grid-cols-1 gap-6">
        <div class="space-y-6">

            <x-common.component-card title="Masukkan Data Organiasi">
                
                <form action="/organizations" method="POST">
                    @csrf

                    <x-form.input.input 
                        class="mb-5"
                        label="Nama Organisasi"
                        type="text"
                        name="name"
                        placeholder="Masukkan nama organisasi"
                        value=""
                    />

                    <x-form.input.input
                        class="mb-5"
                        label="Uang Organisasi"
                        type="number"
                        name="organizations_cash"
                        placeholder="Masukkan Total Keuangan Organisasi"
                        value=""
                    />

                    <x-form.input.select
                    class="mb-5"
                    label="Kategori Organisasi"
                    name="category"
                    placeholder="Pilih kategori organisasi"
                    :options="[
                        'Himpunan' => 'Himpunan',
                        'BEM' => 'BEM',
                        'UKM' => 'UKM',
                    ]"
                />

                    <x-form.input.input
                        class="mb-5"
                        label="Kode Join Organisasi"
                        type="text"
                        name="password_organization"
                        placeholder="Masukkan Kode Untuk verifikasi User Join"
                        value=""
                    />

                    <x-form.input.input
                        class="mb-5"
                        label="Email Organisasi"
                        type="email"
                        name="contact"
                        placeholder="Masukkan Email Organisasi"
                        value=""
                    />

                    <x-form.input.text-area
                        class="mb-3"
                        label="Deskripsi Organisasi"
                        name="description"
                        placeholder="Masukkan Deskripsi Organisasi"
                        rows="4"
                    />

                    <x-form.input.button type="submit">
                        Buat
                    </x-form.input.button>

                </form>

            </x-common.component-card>

        </div>
    </div>
@endsection