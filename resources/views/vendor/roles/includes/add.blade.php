<div class="card h-100">
    <div class="row h-100">
        <div class="card-body text-sm-end text-center ps-sm-0">
            <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                class="btn btn-label-secondary mb-3 text-nowrap add-new-role">
                {{ __('admin.user_management_add_role') }}
            </button>
        </div>
    </div>
</div>


<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="role-title">{{ __('admin.user_management_add_role') }}</h3>
                    <p>{{ __('admin.user_management_set_role_permissions') }}</p>
                </div>
                <!-- Add role form -->
                <form action="{{ route('vendor.roles_employee_store') }}" method="post" class="needs-validation"
                    novalidate>
                    @csrf
                    <div class="col-12 mb-4">
                        <label class="form-label"
                            for="modalRoleName">{{ __('admin.user_management_role_name') }}</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="" required
                            tabindex="-1" />
                    </div>
                    <div class="col-12">
                        <h5>{{ __('admin.user_management_role_permissions') }}</h5>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap">
                                            <h6>{{ __('admin.user_management_role_all_access') }}</h6>
                                            <i class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="{{ __('admin.user_management_role_allows_a_full_access_to_the_system') }}"></i>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input me-1 my-input" type="checkbox"
                                                    id="selectAllAdd" />
                                                <label class="form-check-label" for="selectAll">
                                                    {{ __('admin.user_management_role_selecte_all') }}
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach ($permission_gp as $gp)
                                        <tr>
                                            <td class="text-nowrap">
                                                <h6>{{ $gp->group_name }} :</h6>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @php $permissions  = Spatie\Permission\Models\Permission::where('group_id',$gp->group_id)->get(); @endphp
                                                    @foreach ($permissions as $permission)
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input my-input selectAdd"
                                                                type="checkbox" id="permission "
                                                                value="{{ $permission->id }}" name="permission[]" />
                                                            <label class="form-check-label" for="userManagementRead">
                                                                {{ $permission->short_name }}
                                                            </label>
                                                        </div>
                                                        <br />
                                                    @endforeach


                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 pt-4 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1" id="addRole">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status"
                                    aria-hidden="true"></span>
                            {{ __('admin.submit') }}</button>

                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">
                            {{ __('admin.close') }}
                        </button>
                    </div>
                </form>
                <!--/ Add role form -->
            </div>
        </div>
    </div>
</div>
<!--/ Add Role Modal -->
