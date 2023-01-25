<script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js') }}"></script>

<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var jsTreeSelector = $('#jsTree');

    var selectedCompanyId = $('#selected_company_id');

    var createCompanyCommercialCompanyId = $('#create_company_commercial_company_id');
    var updateCompanyCommercialCompanyId = $('#update_company_commercial_company_id');

    var CreateCompanyButton = $('#CreateCompanyButton');
    var UpdateCompanyButton = $('#UpdateCompanyButton');
    var CreateBranchButton = $('#CreateBranchButton');
    var UpdateBranchButton = $('#UpdateBranchButton');
    var DeleteBranchButton = $('#DeleteBranchButton');
    var CreateDepartmentButton = $('#CreateDepartmentButton');
    var UpdateDepartmentButton = $('#UpdateDepartmentButton');
    var DeleteDepartmentButton = $('#DeleteDepartmentButton');
    var CreateTitleButton = $('#CreateTitleButton');
    var UpdateTitleButton = $('#UpdateTitleButton');
    var DeleteTitleButton = $('#DeleteTitleButton');

    $('body').on('contextmenu', function (e) {
        transactions();
        return false;
    });

    function getCompanies() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.getCompanies') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {},
            success: function (response) {
                selectedCompanyId.empty();
                $.each(response.response, function (i, company) {
                    selectedCompanyId.append(`<option value="${company.id}">${company.title}</option>`);
                });
                selectedCompanyId.val('');
            },
            error: function (error) {
                console.log(error);
                toastr.error('Firma Listesi Alınırken Serviste Bir Hata Oluştu.');
            }
        });
    }

    function getCommercialCompanies() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.commercialCompany.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {},
            success: function (response) {
                createCompanyCommercialCompanyId.empty();
                updateCompanyCommercialCompanyId.empty();
                $.each(response.response, function (i, commercialCompany) {
                    createCompanyCommercialCompanyId.append(`<option value="${commercialCompany.id}">${commercialCompany.name}</option>`);
                    updateCompanyCommercialCompanyId.append(`<option value="${commercialCompany.id}">${commercialCompany.name}</option>`);
                });
                createCompanyCommercialCompanyId.val('');
                updateCompanyCommercialCompanyId.val('');
            },
            error: function (error) {
                console.log(error);
                toastr.error('Kurumsal Firma Listesi Alınırken Serviste Bir Hata Oluştu.');
            }
        });
    }

    function getCompanyTree() {
        $('#loader').show();
        var id = selectedCompanyId.val();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.company.tree') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function (response) {
                var companies = [];
                var branches = [];
                $.each(response.response.branches, function (i, branch) {
                    var departments = [];
                    $.each(branch.departments, function (j, department) {
                        var titles = [];
                        $.each(department.titles, function (k, title) {
                            titles.push({
                                id: `title_${title.id}`,
                                title_id: title.id,
                                type: 'title',
                                icon: 'fas fa-user-tie',
                                text: title.name,
                                children: false
                            });
                        });
                        departments.push({
                            id: `department_${department.id}`,
                            department_id: department.id,
                            type: 'department',
                            icon: 'fas fa-code-branch',
                            text: department.name,
                            state: {
                                opened: true
                            },
                            children: titles
                        });
                    });
                    branches.push({
                        id: `branch_${branch.id}`,
                        branch_id: branch.id,
                        type: 'branch',
                        icon: 'far fa-building',
                        text: branch.name,
                        state: {
                            opened: true
                        },
                        children: departments
                    });
                });
                companies.push({
                    id: response.response.id,
                    company_id: response.response.id,
                    type: 'company',
                    icon: 'fas fa-city',
                    text: response.response.title,
                    state: {
                        opened: true
                    },
                    children: branches
                });
                jsTreeSelector.jstree('destroy');
                jsTreeSelector.jstree({
                    plugins: [
                        'dnd',
                        'types',
                        'conditionalselect',
                        'state',
                        'contextmenu'
                    ],
                    contextmenu: {
                        items: {}
                    },
                    core: {
                        themes: {
                            responsive: false
                        },
                        check_callback: true,
                        data: companies
                    }
                });
                jsTreeSelector.bind('ready.jstree', function (e, data) {
                    jsTreeSelector.jstree().deselect_all(true);
                });

                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Firma Hiyerarşisi Alınırken Serviste Bir Hata Oluştu.');
                $('#loader').hide();
            }
        });
    }

    function transactions() {
        var selectedData = jsTreeSelector.jstree().get_selected(true)[0];
        if (!selectedData) {
            toastr.warning('İşlem Yapmak İçin Bir Veri Seçin!');
        } else {
            if (selectedData.original.type === 'company') {
                companyTransactions();
            }

            if (selectedData.original.type === 'branch') {
                branchTransactions();
            }

            if (selectedData.original.type === 'department') {
                departmentTransactions();
            }

            if (selectedData.original.type === 'title') {
                titleTransactions();
            }
        }
    }

    function companyTransactions() {
        $('#CompanyTransactionsModal').modal('show');
    }

    function branchTransactions() {
        $('#BranchTransactionsModal').modal('show');
    }

    function departmentTransactions() {
        $('#DepartmentTransactionsModal').modal('show');
    }

    function titleTransactions() {
        $('#TitleTransactionsModal').modal('show');
    }

    function createCompany() {
        $('#create_company_title').val('');
        $('#create_company_tax_office').val('');
        $('#create_company_tax_number').val('');
        $('#create_company_record_number').val('');
        createCompanyCommercialCompanyId.val('');
        $('#create_company_uyum_crm_company_id').val('');
        $('#create_company_uyum_crm_branch_id').val('');
        $('#create_company_uyum_crm_branch_code').val('');
        $('#create_company_active_year').val('');
        $('#CreateCompanyModal').modal('show');
    }

    function updateCompany() {
        $('#loader').show();
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.company_id;
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.company.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function (response) {
                $('#CompanyTransactionsModal').modal('hide');
                $('#update_company_title').val(response.response.title);
                $('#update_company_tax_office').val(response.response.tax_office);
                $('#update_company_tax_number').val(response.response.tax_number);
                $('#update_company_record_number').val(response.response.record_number);
                updateCompanyCommercialCompanyId.val(response.response.commercial_company_id);
                $('#update_company_uyum_crm_company_id').val(response.response.uyum_crm_company_id);
                $('#update_company_uyum_crm_branch_id').val(response.response.uyum_crm_branch_id);
                $('#update_company_uyum_crm_branch_code').val(response.response.uyum_crm_branch_code);
                $('#update_company_active_year').val(response.response.active_year);
                $('#update_company_saturday_permit_service').val(response.response.saturday_permit_service);
                $('#UpdateCompanyModal').modal('show');
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Firma Bilgisi Alınırken Serviste Bir Hata Oluştu.');

            }
        });

    }

    function createBranch() {
        $('#CompanyTransactionsModal').modal('hide');
        $('#create_branch_name').val('');
        $('#CreateBranchModal').modal('show');
    }

    function updateBranch() {
        $('#loader').show();
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.branch_id;
        console.log(id);
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.branch.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function (response) {
                $('#BranchTransactionsModal').modal('hide');
                $('#update_branch_name').val(response.response.name);
                $('#UpdateBranchModal').modal('show');
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Şube Bilgisi Alınırken Serviste Bir Hata Oluştu.');
                $('#loader').hide();
            }
        });
    }

    function deleteBranch() {
        $('#BranchTransactionsModal').modal('hide');
        $('#DeleteBranchModal').modal('show');
    }

    function createDepartment() {
        $('#BranchTransactionsModal').modal('hide');
        $('#create_department_name').val('');
        $('#CreateDepartmentModal').modal('show');
    }

    function updateDepartment() {
        $('#loader').show();
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.department_id;
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.department.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function (response) {
                $('#DepartmentTransactionsModal').modal('hide');
                $('#update_department_name').val(response.response.name);
                $('#UpdateDepartmentModal').modal('show');
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Departman Bilgisi Alınırken Serviste Bir Hata Oluştu.');
                $('#loader').hide();
            }
        });
    }

    function deleteDepartment() {
        $('#DepartmentTransactionsModal').modal('hide');
        $('#DeleteDepartmentModal').modal('show');
    }

    function createTitle() {
        $('#DepartmentTransactionsModal').modal('hide');
        $('#create_title_name').val('');
        $('#CreateTitleModal').modal('show');
    }

    function updateTitle() {
        $('#loader').show();
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.title_id;
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.title.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function (response) {
                $('#TitleTransactionsModal').modal('hide');
                $('#update_title_name').val(response.response.name);
                $('#UpdateTitleModal').modal('show');
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Ünvan Bilgisi Alınırken Serviste Bir Hata Oluştu.');
                $('#loader').hide();
            }
        });
    }

    function deleteTitle() {
        $('#TitleTransactionsModal').modal('hide');
        $('#DeleteTitleModal').modal('show');
    }

    getCompanies();
    getCommercialCompanies();

    selectedCompanyId.change(function () {
        getCompanyTree();
    });

    CreateCompanyButton.click(function () {
        var title = $('#create_company_title').val();
        var taxOffice = $('#create_company_tax_office').val();
        var taxNumber = $('#create_company_tax_number').val();
        var recordNumber = $('#create_company_record_number').val();
        var commercialCompanyId = createCompanyCommercialCompanyId.val();
        var uyumCrmCompanyId = $('#create_company_uyum_crm_company_id').val();
        var uyumCrmBranchId = $('#create_company_uyum_crm_branch_id').val();
        var uyumCrmBranchCode = $('#create_company_uyum_crm_branch_code').val();
        var activeYear = $('#create_company_active_year').val();
        var saturdayPermitService = $('#create_company_saturday_permit_service').val();

        if (!title) {
            toastr.warning('Firma Adı Boş Bırakılamaz.');
        } else {
            $('#loader').show();
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.company.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    title: title,
                    taxOffice: taxOffice,
                    taxNumber: taxNumber,
                    recordNumber: recordNumber,
                    commercialCompanyId: commercialCompanyId,
                    uyumCrmCompanyId: uyumCrmCompanyId,
                    uyumCrmBranchId: uyumCrmBranchId,
                    uyumCrmBranchCode: uyumCrmBranchCode,
                    activeYear: activeYear,
                    saturdayPermitService: saturdayPermitService,
                },
                success: function (response) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('user.api.setSingleCompany') }}',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': token
                        },
                        data: {
                            companyId: response.response.id,
                        },
                        error: function (error) {
                            console.log(error);
                            toastr.error('Yeni Firma Bağlantısı Yapılırken Sistemsel Bir Sorun Oluştu!');
                        }
                    });
                    $('#CreateCompanyModal').modal('hide');
                    toastr.success('Firma Başarıyla Oluşturuldu.');
                    getCompanies();
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Firma Oluşturulurken Serviste Bir Hata Oluştu.');
                    $('#loader').hide();
                }
            });
        }
    });

    UpdateCompanyButton.click(function () {
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.company_id;
        var title = $('#update_company_title').val();
        var taxOffice = $('#update_company_tax_office').val();
        var taxNumber = $('#update_company_tax_number').val();
        var recordNumber = $('#update_company_record_number').val();
        var commercialCompanyId = updateCompanyCommercialCompanyId.val();
        var uyumCrmCompanyId = $('#update_company_uyum_crm_company_id').val();
        var uyumCrmBranchId = $('#update_company_uyum_crm_branch_id').val();
        var uyumCrmBranchCode = $('#update_company_uyum_crm_branch_code').val();
        var activeYear = $('#update_company_active_year').val();
        var saturdayPermitService = $('#update_company_saturday_permit_service').val();

        if (!title) {
            toastr.warning('Firma Adı Boş Bırakılamaz.');
        } else {
            $('#loader').show();
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.company.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    id: id,
                    title: title,
                    taxOffice: taxOffice,
                    taxNumber: taxNumber,
                    recordNumber: recordNumber,
                    commercialCompanyId: commercialCompanyId,
                    uyumCrmCompanyId: uyumCrmCompanyId,
                    uyumCrmBranchId: uyumCrmBranchId,
                    uyumCrmBranchCode: uyumCrmBranchCode,
                    activeYear: activeYear,
                    saturdayPermitService: saturdayPermitService,
                },
                success: function () {
                    $('#UpdateCompanyModal').modal('hide');
                    toastr.success('Firma Başarıyla Güncellendi.');
                    selectedCompanyId.find('option:selected').text(title);
                    selectedCompanyId.select2();
                    getCompanyTree();
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Firma Güncellenirken Serviste Bir Hata Oluştu.');
                    $('#loader').hide();
                }
            });
        }
    });

    CreateBranchButton.click(function () {
        var companyId = jsTreeSelector.jstree().get_selected(true)[0].original.company_id;
        var name = $('#create_branch_name').val();
        if (!name) {
            toastr.warning('Şube Adı Boş Bırakılamaz.');
        } else {
            $('#loader').show();
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.branch.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    companyId: companyId,
                    name: name,
                },
                success: function (response) {
                    $('#CreateBranchModal').modal('hide');
                    toastr.success('Şube Başarıyla Oluşturuldu.');
                    getCompanyTree();
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Şube Oluşturulurken Serviste Bir Hata Oluştu.');
                    $('#loader').hide();
                }
            });
        }
    });

    UpdateBranchButton.click(function () {
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.branch_id;
        var name = $('#update_branch_name').val();
        if (!name) {
            toastr.warning('Şube Adı Boş Bırakılamaz.');
        } else {
            $('#loader').show();
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.branch.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    id: id,
                    name: name,
                },
                success: function () {
                    $('#UpdateBranchModal').modal('hide');
                    toastr.success('Şube Başarıyla Güncellendi.');
                    getCompanyTree();
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Şube Güncellenirken Serviste Bir Hata Oluştu.');
                    $('#loader').hide();
                }
            });
        }
    });

    DeleteBranchButton.click(function () {
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.branch_id;
        $('#loader').show();
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.branch.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function () {
                $('#DeleteBranchModal').modal('hide');
                toastr.success('Şube Başarıyla Silindi.');
                getCompanyTree();
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Şube Silinirken Serviste Bir Hata Oluştu.');
                $('#loader').hide();
            }
        });
    });

    CreateDepartmentButton.click(function () {
        var branchId = jsTreeSelector.jstree().get_selected(true)[0].original.branch_id;
        var name = $('#create_department_name').val();
        if (!name) {
            toastr.warning('Departman Adı Boş Bırakılamaz.');
        } else {
            $('#loader').show();
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.department.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    branchId: branchId,
                    name: name,
                },
                success: function (response) {
                    $('#CreateDepartmentModal').modal('hide');
                    toastr.success('Departman Başarıyla Oluşturuldu.');
                    getCompanyTree();
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Departman Oluşturulurken Serviste Bir Hata Oluştu.');
                    $('#loader').hide();
                }
            });
        }
    });

    UpdateDepartmentButton.click(function () {
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.department_id;
        var name = $('#update_department_name').val();
        if (!name) {
            toastr.warning('Departman Adı Boş Bırakılamaz.');
        } else {
            $('#loader').show();
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.department.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    id: id,
                    name: name,
                },
                success: function () {
                    $('#UpdateDepartmentModal').modal('hide');
                    toastr.success('Departman Başarıyla Güncellendi.');
                    getCompanyTree();
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Departman Güncellenirken Serviste Bir Hata Oluştu.');
                    $('#loader').hide();
                }
            });
        }
    });

    DeleteDepartmentButton.click(function () {
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.department_id;
        $('#loader').show();
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.department.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function () {
                $('#DeleteDepartmentModal').modal('hide');
                toastr.success('Departman Başarıyla Silindi.');
                getCompanyTree();
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Departman Silinirken Serviste Bir Hata Oluştu.');
                $('#loader').hide();
            }
        });
    });

    CreateTitleButton.click(function () {
        var departmentId = jsTreeSelector.jstree().get_selected(true)[0].original.department_id;
        var name = $('#create_title_name').val();
        if (!name) {
            toastr.warning('Ünvan Adı Boş Bırakılamaz.');
        } else {
            $('#loader').show();
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.title.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    departmentId: departmentId,
                    name: name,
                },
                success: function (response) {
                    $('#CreateTitleModal').modal('hide');
                    toastr.success('Ünvan Başarıyla Oluşturuldu.');
                    getCompanyTree();
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Ünvan Oluşturulurken Serviste Bir Hata Oluştu.');
                    $('#loader').hide();
                }
            });
        }
    });

    UpdateTitleButton.click(function () {
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.title_id;
        var name = $('#update_title_name').val();
        if (!name) {
            toastr.warning('Ünvan Adı Boş Bırakılamaz.');
        } else {
            $('#loader').show();
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.title.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    id: id,
                    name: name,
                },
                success: function () {
                    $('#UpdateTitleModal').modal('hide');
                    toastr.success('Ünvan Başarıyla Güncellendi.');
                    getCompanyTree();
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Ünvan Güncellenirken Serviste Bir Hata Oluştu.');
                    $('#loader').hide();
                }
            });
        }
    });

    DeleteTitleButton.click(function () {
        var id = jsTreeSelector.jstree().get_selected(true)[0].original.title_id;
        $('#loader').show();
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.title.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function () {
                $('#DeleteTitleModal').modal('hide');
                toastr.success('Ünvan Başarıyla Silindi.');
                getCompanyTree();
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Ünvan Silinirken Serviste Bir Hata Oluştu.');
                $('#loader').hide();
            }
        });
    });

</script>
