@extends('user.layouts.auth')
@section('title', 'Şifrenizi Sıfırlayın | ')

@section('content')

    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <a href="#" class="mb-12">
            <img alt="Logo" src="{{ asset('assets/media/logos/favicon.png') }}" class="h-75px" />
        </a>
        <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <div class="form w-100">
                <div class="text-center mb-10">
                    <div class="text-gray-400 fw-bold fs-4">Şifrenizi Sıfırlayın</div>
                </div>
                <div class="fv-row mb-10">
                    <div class="d-flex flex-stack mb-2">
                        <label for="new_password" class="form-label fw-bolder text-dark fs-6 mb-0">Yeni Şifreniz</label>
                    </div>
                    <input id="new_password" type="password" class="form-control form-control-lg form-control-solid" autocomplete="off" />
                </div>
                <div class="fv-row mb-10">
                    <div class="d-flex flex-stack mb-2">
                        <label for="confirm_new_password" class="form-label fw-bolder text-dark fs-6 mb-0">Yeni Şifrenizi Tekrar Girin</label>
                    </div>
                    <input id="confirm_new_password" type="password" class="form-control form-control-lg form-control-solid" autocomplete="off" />
                </div>
                <div class="text-center">
                    <button type="button" id="ResetPasswordButton" class="btn btn-lg btn-primary w-100 mb-5">Güncelle</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.authentication.resetPassword.components.style')
@endsection

@section('customScripts')
    @include('user.modules.authentication.resetPassword.components.script')
@endsection
