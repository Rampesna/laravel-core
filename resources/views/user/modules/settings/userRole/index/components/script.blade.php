<script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js') }}"></script>

<script>
    $('#loader').hide();
    var allUserPermissions = [];

    var userRoles = $('#userRoles');

    var jsTreeSelector = $('#jsTree');

    var page = $('#page');
    var pageUpButton = $('#pageUp');
    var pageDownButton = $('#pageDown');
    var pageSizeSelector = $('#pageSize');

    var keywordFilter = $('#keyword');

    var CreateUserRoleButton = $('#CreateUserRoleButton');
    var UpdateUserRoleButton = $('#UpdateUserRoleButton');
    var DeleteUserRoleButton = $('#DeleteUserRoleButton');

    function setUserPermissionsTree(userPermissions, selectedNodeUserPermissions) {

        var list = [];
        $.each(userPermissions, function (i, userPermission) {

            var selected = false;
            $.each(selectedNodeUserPermissions, function (j, selectedNodeUserPermission) {
                if (parseInt(userPermission.id) === parseInt(selectedNodeUserPermission.id)) {
                    if (Object.keys(userPermission.children).length === 0) {
                        selected = true;
                    }
                }
            });
            list.push({
                id: userPermission.id,
                permission_id: userPermission.id,
                type: 'permission',
                icon: 'fas fa-user-circle',
                text: userPermission.name,
                state: {
                    selected: selected,
                },
                children: Object.keys(userPermission.children).length > 0 ? setUserPermissionsTree(userPermission.children, selectedNodeUserPermissions) : false
            });
        });
        return list;
    }

    $(document).delegate('.toggleAuthorizations', 'click', function () {
        $(`#${$(this).data('id')}_authorizations`).toggle();
    })

    function createUserRole() {
        $('#create_user_role_name').val('');
        $('#CreateUserRoleModal').modal('show');
    }

    function updateUserRole(id) {
        $('#loader').show();
        $('#update_user_role_id').val(id);
        $.ajax({
            type: 'get',
            url: '{{ route('roles.api.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                roleId: id,
            },
            success: function (response) {
                $('#UpdateUserRoleModal').modal('show');
                $('#update_user_role_name').val(response.data.name);
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Rol Verileri Alınırken Serviste Bir Sorun Oluştu!');
                $('#loader').hide();
            }
        });
    }

    function updateUserRoleUserPermissions(roleId) {
        $('#update_user_role_user_permissions_role_id').val(roleId);
        $.ajax({
            type: 'get',
            url: '{{ route('roles.api.getPermissions') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                roleId: roleId,
            },
            success: function (response) {
                console.log(response);
                jsTreeSelector.jstree('destroy');
                jsTreeSelector.jstree({
                    plugins: [
                        'dnd',
                        'types',
                        'conditionalselect',
                        'checkbox',
                    ],
                    contextmenu: {
                        items: {}
                    },
                    core: {
                        themes: {
                            responsive: false
                        },
                        check_callback: true,
                        data: setUserPermissionsTree(allUserPermissions, response.data)
                    }
                });
                jsTreeSelector.bind("select_node.jstree deselect_node.jstree", function (e, data) {
                    var nodes = [];
                    var selectedNodes = jsTreeSelector.jstree(true).get_selected('full',true);
                    $.each(selectedNodes, function (i, selectedNode) {
                        nodes.push(parseInt(selectedNode.id));
                        if (selectedNode.parent !== '#') {
                            if ($.inArray(parseInt(selectedNode.parent), nodes) === -1) {
                                nodes.push(parseInt(selectedNode.parent));
                            }
                        }
                    });
                    setUserRoleUserPermissions(nodes);
                });

                $('#UpdateUserRoleUserPermissionsModal').modal('show');
            },
            error: function (error) {
                console.log(error);
                toastr.error('Rol Yetki Listesi Alınırken Serviste Bir Sorun Oluştu!');
            }
        });
    }

    function deleteUserRole(id) {
        $('#delete_user_role_id').val(id);
        $('#DeleteUserRoleModal').modal('show');
    }

    function getUserPermissions() {
        $.ajax({
            type: 'get',
            url: '{{ route('permissions.api.getByParentId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                parentId: null
            },
            success: function (response) {
                allUserPermissions = response.data;
            },
            error: function (error) {
                console.log(error);
                toastr.error('Yetkilendirilebilir İşlem Listesi Alınırken Serviste Bir Sorun Oluştu!');
            }
        });
    }

    function getUserRoles() {
        $('#loader').show();
        var companyIds = selectedCompaniesInput.val();
        var pageIndex = parseInt(page.html()) - 1;
        var pageSize = pageSizeSelector.val();
        var keyword = keywordFilter.val();

        $.ajax({
            type: 'get',
            url: '{{ route('roles.api.getAllUserRoles') }}',
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
                userRoles.empty();
                $('#totalCountSpan').text(response.data.totalCount);
                $('#startCountSpan').text(parseInt(((pageIndex) * pageSize)) + 1);
                $('#endCountSpan').text(parseInt(parseInt(((pageIndex) * pageSize)) + 1) + parseInt(pageSize) > response.data.totalCount ? response.data.totalCount : parseInt(((pageIndex) * pageSize)) + 1 + parseInt(pageSize));
                $.each(response.data.userRoles, function (i, userRole) {
                    userRoles.append(`
                    <tr>
                        <td>
                            ${userRole.name}
                        </td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-icon btn-sm" type="button" id="${userRole.id}_Dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-th"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="${userRole.id}_Dropdown" style="width: 175px">
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="updateUserRole(${userRole.id})" title="Düzenle"><i class="fas fa-edit me-2 text-primary"></i> <span class="text-dark">Düzenle</span></a>
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="updateUserRoleUserPermissions(${userRole.id})" title="Düzenle"><i class="fas fa-shield-alt me-2 text-info"></i> <span class="text-dark">Rol Yetkileri</span></a>
                                    <hr class="text-muted">
                                    <a class="dropdown-item cursor-pointer py-3 ps-6" onclick="deleteUserRole(${userRole.id})" title="Sil"><i class="fas fa-trash-alt me-3 text-danger"></i> <span class="text-dark">Sil</span></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    `);
                });

                if (response.data.totalCount <= (pageIndex + 1) * pageSize) {
                    pageUpButton.attr('disabled', true);
                } else {
                    pageUpButton.attr('disabled', false);
                }

                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Rol Listesi Alınırken Serviste Bir Sorun Oluştu.');
                $('#loader').hide();
            }
        });
    }

    function setUserRoleUserPermissions(userPermissions) {
        var roleId = $('#update_user_role_user_permissions_role_id').val();
        var userPermissionIds = $.map(userPermissions, function (userPermission) {
            return parseInt(userPermission);
        });

        $.ajax({
            type: 'post',
            url: '{{ route('roles.api.attachPermission') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                roleId: parseInt(roleId),
                permissionIds: userPermissionIds,
            },
            error: function (error) {
                console.log(error);
                toastr.error('Rol Yetkileri Kaydedilirken Serviste Bir Sorun Oluştu!');
            }
        });
    }

    getUserPermissions();
    getUserRoles();

    selectedCompaniesInput.change(function () {
        getUserRoles();
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
        getUserRoles();
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

    CreateUserRoleButton.click(function () {
        var name = $('#create_user_role_name').val();
        console.log(name)

        if (!name) {
            toastr.warning('Rol Adı Zorunludur!');
        } else {
            $('#loader').show();
            $('#CreateUserRoleModal').modal('hide');
            $.ajax({
                type: 'post',
                url: '{{ route('roles.api.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    name: name
                },
                success: function () {
                    toastr.success('Rol Başarıyla Oluşturuldu!');
                    changePage(1);
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Rol Oluşturulurken Serviste Bir Sorun Oluştu!');
                    $('#loader').hide();
                }
            });
        }
    });

    UpdateUserRoleButton.click(function () {
        var id = $('#update_user_role_id').val();
        var name = $('#update_user_role_name').val();

        if (!name) {
            toastr.warning('Rol Adı Zorunludur!');
        } else {
            $('#loader').show();
            $('#UpdateUserRoleModal').modal('hide');
            $.ajax({
                type: 'put',
                url: '{{ route('roles.api.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    id: id,
                    name: name,
                },
                success: function () {
                    toastr.success('Rol Başarıyla Güncellendi!');
                    changePage(parseInt(page.html()));
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Rol Güncellenirken Serviste Bir Sorun Oluştu!');
                    $('#loader').hide();
                }
            });
        }
    });

    DeleteUserRoleButton.click(function () {
        var id = $('#delete_user_role_id').val();
        $('#loader').show();
        $('#DeleteUserRoleModal').modal('hide');
        $.ajax({
            type: 'delete',
            url: '{{ route('roles.api.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                roleId: id,
            },
            success: function () {
                toastr.success('Rol Başarıyla Silindi!');
                changePage(parseInt(page.html()));
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Rol Silinirken Serviste Bir Sorun Oluştu!');
                $('#loader').hide();
            }
        });
    });

</script>
