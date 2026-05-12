@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Buat Organisasi" />
    
    <div class="grid grid-cols-1 gap-6 ">
        <div class="space-y-6">
            {{-- <x-form.form-elements.default-inputs /> --}}
            {{--  
            <x-form.form-elements.select-inputs />
            <x-form.form-elements.text-area-inputs />
            <x-form.form-elements.input-states /> --}}
        <x-common.component-card title="Masukkan Data Organiasi">
        
        <form action="/organizations" method="POST">
                @csrf
           <x-form.input.input
                label="Nama Organisasi"
                type="text"
                name="name"
                placeholder="Masukkan nama organisasi"
                value=""
            />
           <x-form.input.input
                label="Uang Organisasi"
                type="number"
                name="organizations_cash"
                placeholder="Masukkan Total Keuangan Organisasi"
                value=""
            />
           <x-form.input.input
                label="Email Organisasi"
                type="email"
                name="contact"
                placeholder="Masukkan Email Organisasi"
                value=""
            />
           <x-form.input.text-area
                label="Deskripsi Organisasi",
                name="description",
                placeholder='Masukkan Deskripsi Organisasi',
                rows= "4"
            />

            <x-form.input.button class="mt-3" type="submit">
                Buat
            </x-form.input.button>
            
        </form>


        </div>
        <div class="space-y-6">
            {{-- <x-form.form-elements.input-group />
            <x-form.form-elements.file-input-example />
            <x-form.form-elements.checkbox-component />
            <x-form.form-elements.radio-buttons />
            <x-form.form-elements.toggle-switch />
            <x-form.form-elements.dropzone /> --}}
        </div>
    </x-common.component-card>
    </div>
@endsection
