@extends('user.layouts.master')
@section('title', 'Ayarlar / Firma Yönetimi | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <a href="{{ route('user.web.settings.index') }}" class="fas fa-lg fa-backward cursor-pointer me-5"></a>
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Ayarlar / Firma Yönetimi</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.settings.company.index.modals.companyTransactions')
    @include('user.modules.settings.company.index.modals.branchTransactions')
    @include('user.modules.settings.company.index.modals.departmentTransactions')
    @include('user.modules.settings.company.index.modals.titleTransactions')

    @include('user.modules.settings.company.index.modals.createCompany')
    @include('user.modules.settings.company.index.modals.updateCompany')

    @include('user.modules.settings.company.index.modals.createBranch')
    @include('user.modules.settings.company.index.modals.updateBranch')
    @include('user.modules.settings.company.index.modals.deleteBranch')

    @include('user.modules.settings.company.index.modals.createDepartment')
    @include('user.modules.settings.company.index.modals.updateDepartment')
    @include('user.modules.settings.company.index.modals.deleteDepartment')

    @include('user.modules.settings.company.index.modals.createTitle')
    @include('user.modules.settings.company.index.modals.updateTitle')
    @include('user.modules.settings.company.index.modals.deleteTitle')

    <div class="row">
        <div class="col-xl-6">
            <div class="row">
                <div class="col-xl-12 d-grid">
                    <button onclick="transactions()" class="btn btn-sm btn-primary">
                        <span class="svg-icon svg-icon-muted svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z" fill="black"/>
                                <path d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z" fill="black"/>
                                <path opacity="0.3" d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z" fill="black"/>
                                <path opacity="0.3" d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z" fill="black"/>
                            </svg>
                        </span>
                        <span>İşlemler</span>
                    </button>
                </div>
            </div>
            <hr class="text-muted">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <label for="selected_company_id">Firma Seçimi</label>
                                <div class="input-group flex-nowrap">
                                    <select id="selected_company_id" class="form-select form-select-solid select2Input" data-control="select2" data-placeholder="Firma Seçimi"></select>
                                    <button class="btn btn-success btn-icon" onclick="createCompany()">
                                        <i class="fa fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr class="text-muted">
                        <div class="row">
                            <div class="col-xl-12 mb-5">
                                <div id="jsTreeCardSelector">
                                    <div id="jsTree">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.settings.company.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.settings.company.index.components.script')
@endsection
