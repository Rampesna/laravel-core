@extends('user.layouts.auth')
@section('title', 'Şifremi Unuttum | ')

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
                        <label for="email" class="form-label fw-bolder text-dark fs-6 mb-0">E-posta Adresiniz</label>
                        <a href="{{ route('user.web.authentication.login.index') }}" class="link-primary fs-6 fw-bolder" tabindex="-1">Giriş Yapın</a>
                    </div>
                    <input id="email" type="text" class="form-control form-control-lg form-control-solid emailMask" autocomplete="off" />
                </div>
                <div class="text-center">
                    <button type="button" id="ResetPasswordButton" class="btn btn-lg btn-primary w-100 mb-5">Gönder</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.authentication.forgotPassword.components.style')
@endsection

@section('customScripts')
    @include('user.modules.authentication.forgotPassword.components.script')
@endsection
