<script>

    var users = $('#users');

    var page = $('#page');
    var pageUpButton = $('#pageUp');
    var pageDownButton = $('#pageDown');
    var pageSizeSelector = $('#pageSize');

    var keywordFilter = $('#keyword');

    var CreateUserButton = $('#CreateUserButton');
    var UpdateUserButton = $('#UpdateUserButton');
    var DeleteUserButton = $('#DeleteUserButton');
    var SetUserSuspendButton = $('#SetUserSuspendButton');

    var createUserCompanyIds = $('#create_user_company_ids');
    var updateUserCompanyIds = $('#update_user_company_ids');

    var createUserRoleId = $('#create_user_role_id');
    var updateUserRoleId = $('#update_user_role_id');

    var createUserTypeId = $('#create_user_type_id');
    var updateUserTypeId = $('#update_user_type_id');

    function createUser() {
        createUserCompanyIds.val([]);
        createUserRoleId.val('');
        $('#create_user_name').val('');
        $('#create_user_email').val('');
        $('#create_user_phone').val('');
        $('#create_user_identity').val('');
        $('#CreateUserModal').modal('show');
    }

    function updateUser(id) {
        $('#loader').show();
        $('#update_user_id').val(id);
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.user.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function (response) {
                updateUserCompanyIds.val($.map(response.response.companies, function (company) {
                    return company.id;
                }));
                updateUserRoleId.val(response.response.role_id);
                updateUserTypeId.val(response.response.type_id);
                $('#update_user_name').val(response.response.name);
                $('#update_user_email').val(response.response.email);
                $('#update_user_phone').val(response.response.phone);
                $('#update_user_identity').val(response.response.identity);
                $('#UpdateUserModal').modal('show');
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Kullanıcı Verileri Alınırken Serviste Bir Sorun Oluştu!');
                $('#loader').hide();
            }
        });
    }

    function deleteUser(id) {
        $('#delete_user_id').val(id);
        $('#DeleteUserModal').modal('show');
    }

    function setUserSuspend(userId, suspend) {
        $('#set_user_suspend_user_id').val(userId);
        $('#set_user_suspend_suspend').val(suspend);
        if (suspend === 0) {
            $('#set_user_suspend_span').text('Aktif').removeClass('text-danger').addClass('text-success');
        } else {
            $('#set_user_suspend_span').text('Pasif').removeClass('text-success').addClass('text-danger');
        }
        $('#SetUserSuspendModal').modal('show');
    }

    function getCompanies() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.company.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {},
            success: function (response) {
                createUserCompanyIds.empty();
                updateUserCompanyIds.empty();
                $.each(response.response, function (i, company) {
                    createUserCompanyIds.append($('<option>', {
                        value: company.id,
                        text: company.title
                    }));
                    updateUserCompanyIds.append($('<option>', {
                        value: company.id,
                        text: company.title
                    }));
                });
            },
            error: function (error) {
                console.log(error);
                toastr.error('Şirketler Alınırken Serviste Bir Sorun Oluştu!');
            }
        });
    }

    function getUserTypes() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.userType.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {},
            success: function (response) {
                createUserTypeId.empty();
                updateUserTypeId.empty();
                $.each(response.response, function (i, userType) {
                    createUserTypeId.append($('<option>', {
                        value: userType.id,
                        text: userType.name
                    }));
                    updateUserTypeId.append($('<option>', {
                        value: userType.id,
                        text: userType.name
                    }));
                });
            },
            error: function (error) {
                console.log(error);
                if (parseInt(error.status) === 422) {
                    $.each(error.responseJSON.response, function (i, error) {
                        toastr.error(error[0]);
                    });
                } else {
                    toastr.error(error.responseJSON.message);
                }
            }
        });
    }

    function getUserRoles() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.userRole.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {},
            success: function (response) {
                $.each(response.response, function (i, role) {
                    createUserRoleId.append($('<option>', {
                        value: role.id,
                        text: role.name
                    }));
                    updateUserRoleId.append($('<option>', {
                        value: role.id,
                        text: role.name
                    }));
                });
            },
            error: function (error) {
                console.log(error);
                toastr.error('Kullanıcı Rolleri Alınırken Serviste Bir Sorun Oluştu!');
            }
        });
    }

    function getUsers() {
        $('#loader').show();
        var companyIds = SelectedCompanies.val();
        var pageIndex = parseInt(page.html()) - 1;
        var pageSize = pageSizeSelector.val();
        var keyword = keywordFilter.val();

        $.ajax({
            type: 'get',
            url: '{{ route('user.api.user.index') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                companyIds: companyIds,
                pageIndex: pageIndex,
                pageSize: pageSize,
                keyword: keyword,
            },
            success: function (response) {
                users.empty();
                $('#totalCountSpan').text(response.response.totalCount);
                $('#startCountSpan').text(parseInt(((pageIndex) * pageSize)) + 1);
                $('#endCountSpan').text(parseInt(parseInt(((pageIndex) * pageSize)) + 1) + parseInt(pageSize) > response.response.totalCount ? response.response.totalCount : parseInt(((pageIndex) * pageSize)) + 1 + parseInt(pageSize));
                $.each(response.response.users, function (i, user) {
                    users.append(`
                    <tr>
                        <td class="text-start">
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-icon btn-sm" type="button" id="${user.id}_Dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-th"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="${user.id}_Dropdown" style="width: 175px">
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="updateUser(${user.id})" title="Düzenle"><i class="fas fa-edit me-2 text-primary"></i> <span class="text-dark">Düzenle</span></a>
                                    <hr class="text-muted">
                                    <a class="dropdown-item cursor-pointer py-3 ps-6" onclick="deleteUser(${user.id})" title="Sil"><i class="fas fa-trash-alt me-3 text-danger"></i> <span class="text-dark">Sil</span></a>
                                </div>
                            </div>
                        </td>
                        <td>
                            ${user.type ? user.type.name : ''}
                        </td>
                        <td>
                            ${user.name}
                        </td>
                        <td>
                            ${user.email}
                        </td>
                        <td>
                            ${user.phone ?? '--'}
                        </td>
                        <td>
                            ${user.role ? user.role.name : '--'}
                        </td>
                        <td>
                            ${parseInt(user.suspend) === 1 ? `<span class="badge badge-danger cursor-pointer" onclick="setUserSuspend(${user.id}, 0)">Pasif</span>` : `<span class="badge badge-success cursor-pointer" onclick="setUserSuspend(${user.id}, 1)">Aktif</span>`}
                        </td>
                    </tr>
                    `);
                });

                if (response.response.totalCount <= (pageIndex + 1) * pageSize) {
                    pageUpButton.attr('disabled', true);
                } else {
                    pageUpButton.attr('disabled', false);
                }

                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Kullanıcılar Alınırken Serviste Bir Sorun Oluştu.');
                $('#loader').hide();
            }
        });
    }

    getCompanies();
    getUserTypes();
    getUserRoles();
    getUsers();

    SelectedCompanies.change(function () {
        getUsers();
    });

    keywordFilter.on('keypress', function (e) {
        if (e.which === 13) {
            changePage(1);
        }
    });

    function changePage(newPage) {
        if (newPage === 1) {
            pageDownButton.attr('disabled', true);
        } else {
            pageDownButton.attr('disabled', false);
        }

        page.html(newPage);
        getUsers();
    }

    pageUpButton.click(function () {
        changePage(parseInt(page.html()) + 1);
    });

    pageDownButton.click(function () {
        changePage(parseInt(page.html()) - 1);
    });

    pageSizeSelector.change(function () {
        changePage(1);
    });

    CreateUserButton.click(function () {
        var companyIds = createUserCompanyIds.val();
        var roleId = createUserRoleId.val();
        var typeId = createUserTypeId.val();
        var name = $('#create_user_name').val();
        var email = $('#create_user_email').val();
        var phone = $('#create_user_phone').val();
        var identity = $('#create_user_identity').val();

        if (companyIds.length === 0) {
            toastr.warning('En Az 1 Firma Seçmelisiniz!');
        } else if (!roleId) {
            toastr.warning('Kullanıcı Rolü Seçmediniz!');
        } else if (!typeId) {
            toastr.warning('Kullanıcı Türü Seçmediniz!');
        } else if (!name) {
            toastr.warning('Ad Soyad Girmediniz!');
        } else if (!email) {
            toastr.warning('E-Posta Adresi Girmediniz!');
        } else {
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.user.getByEmail') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    email: email,
                },
                success: function () {
                    toastr.warning('Bu E-Posta Adresi Zaten Kullanılıyor!');
                },
                error: function (error) {
                    console.log(error);
                    if (parseInt(error.status) === 404) {
                        $('#loader').show();
                        $('#CreateUserModal').modal('hide');
                        $.ajax({
                            type: 'post',
                            url: '{{ route('user.api.user.create') }}',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': token
                            },
                            data: {
                                roleId: roleId,
                                typeId: typeId,
                                name: name,
                                email: email,
                                phone: phone,
                                identity: identity,
                            },
                            success: function (response) {
                                $.ajax({
                                    type: 'post',
                                    url: '{{ route('user.api.user.setUserCompanies') }}',
                                    headers: {
                                        'Accept': 'application/json',
                                        'Authorization': token
                                    },
                                    data: {
                                        userId: response.response.id,
                                        companyIds: companyIds,
                                    },
                                    error: function (error) {
                                        console.log(error);
                                        toastr.error('Kullanıcı Firmaları Eklenirken Serviste Bir Sorun Oluştu!');
                                    }
                                });
                                toastr.success('Kullanıcı Başarıyla Oluşturuldu!');
                                changePage(parseInt(page.html()));
                            },
                            error: function (error) {
                                console.log(error);
                                toastr.error('Kullanıcı Oluşturulurken Serviste Bir Sorun Oluştu!');
                            }
                        });
                    } else {
                        toastr.error('E-posta Kontrolü Yapılırken Serviste Bir Sorun Oluştu!');
                    }
                }
            });
        }
    });

    UpdateUserButton.click(function () {
        var id = $('#update_user_id').val();
        var companyIds = updateUserCompanyIds.val();
        var roleId = updateUserRoleId.val();
        var typeId = updateUserTypeId.val();
        var name = $('#update_user_name').val();
        var email = $('#update_user_email').val();
        var phone = $('#update_user_phone').val();
        var identity = $('#update_user_identity').val();

        if (companyIds.length === 0) {
            toastr.warning('En Az 1 Firma Seçmelisiniz!');
        } else if (!roleId) {
            toastr.warning('Kullanıcı Rolü Seçmediniz!');
        } else if (!typeId) {
            toastr.warning('Kullanıcı Türü Seçmediniz!');
        } else if (!name) {
            toastr.warning('Ad Soyad Girmediniz!');
        } else if (!email) {
            toastr.warning('E-Posta Adresi Girmediniz!');
        } else {
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.user.getByEmail') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    email: email,
                    exceptId: id,
                },
                success: function () {
                    toastr.warning('Bu E-Posta Adresi Zaten Kullanılıyor!');
                },
                error: function (error) {
                    console.log(error);
                    if (parseInt(error.status) === 404) {
                        $('#loader').show();
                        $('#UpdateUserModal').modal('hide');
                        $.ajax({
                            type: 'put',
                            url: '{{ route('user.api.user.update') }}',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': token
                            },
                            data: {
                                id: id,
                                roleId: roleId,
                                typeId: typeId,
                                name: name,
                                email: email,
                                phone: phone,
                                identity: identity,
                            },
                            success: function (response) {
                                $.ajax({
                                    type: 'post',
                                    url: '{{ route('user.api.user.setUserCompanies') }}',
                                    headers: {
                                        'Accept': 'application/json',
                                        'Authorization': token
                                    },
                                    data: {
                                        userId: response.response.id,
                                        companyIds: companyIds,
                                    },
                                    error: function (error) {
                                        console.log(error);
                                        toastr.error('Kullanıcı Firmaları Eklenirken Serviste Bir Sorun Oluştu!');
                                    }
                                });
                                toastr.success('Kullanıcı Başarıyla Güncellendi!');
                                changePage(parseInt(page.html()));
                            },
                            error: function (error) {
                                console.log(error);
                                toastr.error('Kullanıcı Güncellenirken Serviste Bir Sorun Oluştu!');
                            }
                        });
                    } else {
                        toastr.error('E-posta Kontrolü Yapılırken Serviste Bir Sorun Oluştu!');
                    }
                }
            });
        }
    });

    DeleteUserButton.click(function () {
        var id = $('#delete_user_id').val();
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.user.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function () {
                toastr.success('Kullanıcı Başarıyla Silindi!');
                $('#DeleteUserModal').modal('hide');
                changePage(parseInt(page.html()));
            },
            error: function (error) {
                console.log(error);
                toastr.error('Kullanıcı Silinirken Serviste Bir Sorun Oluştu!');
            }
        });
    });

    SetUserSuspendButton.click(function () {
        $('#loader').show();
        var userId = $('#set_user_suspend_user_id').val();
        var suspend = $('#set_user_suspend_suspend').val();
        $.ajax({
            type: 'put',
            url: '{{ route('user.api.user.setSuspend') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                userId: userId,
                suspend: suspend,
            },
            success: function () {
                toastr.success('İşlem Başarılı');
                $('#SetUserSuspendModal').modal('hide');
                changePage(parseInt(page.html()));
            },
            error: function (error) {
                console.log(error);
                toastr.error('İşlem Yapılırken Serviste Bir Sorun Oluştu!');
                $('#loader').hide();
            }
        });
    });

</script>
