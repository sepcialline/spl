<div class="row">
    <div class="col-2">
        {{-- Edit Role Button --}}
        <button data-bs-target="#editRoleModal{{ $role->id }}" data-bs-toggle="modal"
            class="btn btn-label-success mb-3 text-nowrap add-new-role">
            {{ __('admin.edit') }}
        </button>
    </div>
    <div class="col-2">
        {{-- Show Role Button --}}
        <button data-bs-target="#showRoleModal{{ $role->id }}" data-bs-toggle="modal"
            class="btn btn-label-dark mb-3 text-nowrap add-new-role">
            {{ __('admin.show') }}
        </button>
    </div>
    <div class="col-2 mx-2">
        {{-- Delete Role Button --}}
        <form method="POST" action="{{ route('vendor.roles_employee_destroy', $role->id) }}">
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button type="submit" class="btn btn-danger confirm-button ">{{ __('admin.delete') }}</button>
        </form>
    </div>
</div>






<!-- edit Role Modal -->
<div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="role-title">{{ __('admin.user_management_role_edit') }}</h3>
                    <p>{{ __('admin.user_management_set_role_permissions') }}</p>
                </div>
                <!-- Add role form -->
                <form action="{{ route('vendor.roles_employee_update') }}" method="post" class="needs-validation"
                    novalidate>
                    @csrf
                    <input type="hidden" value="{{ $role->id }}" name="id">
                    <div class="col-12 mb-4">
                        <label class="form-label"
                            for="modalRoleName">{{ __('admin.user_management_role_name') }}</label>
                        <input type="text" id="name" name="name" class="form-control" required
                            placeholder="Enter a role name" value="{{ $role->name }}" tabindex="-1" />
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
                                            {{-- <i class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Allows a full access to the system"></i> --}}
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input  my-input" type="checkbox"
                                                    id="selectAllEdit" />
                                                <label class="form-check-label" for="selectAllEdit">
                                                    {{ __('admin.user_management_role_selecte_all') }}
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $perm_role = $role->permissions->pluck('id');
                                    @endphp
                                    @foreach ($permission_gp as $gp)
                                        <tr>
                                            <td class="text-nowrap">
                                                <h6>{{ $gp->group_name }} :</h6>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @php $permissions  = Spatie\Permission\Models\Permission::where('group_id',$gp->group_id)->get(); @endphp
                                                    @php $per = Spatie\Permission\Models\Permission::whereIn('id', $perm_role)->pluck('id'); @endphp
                                                    @foreach ($permissions as $permission)
                                                        @if (Spatie\Permission\Models\Permission::where('id', $permission->id)->whereIn('id', $perm_role)->first())
                                                            <div class="form-check me-3 me-lg-5">
                                                                <input class="form-check-input  my-input selectEdit"
                                                                    type="checkbox" checked id="permission"
                                                                    value="{{ $permission->id }}"
                                                                    name="permission[]" />
                                                                <label class="form-check-label"
                                                                    for="userManagementRead">
                                                                    {{ $permission->short_name }}
                                                                </label>
                                                            </div>
                                                            <br />
                                                        @else
                                                            <div class="form-check me-3 me-lg-5">
                                                                <input class="form-check-input  my-input selectEdit"
                                                                    type="checkbox" id="permission "
                                                                    value="{{ $permission->id }}"
                                                                    name="permission[]" />
                                                                <label class="form-check-label"
                                                                    for="userManagementRead">
                                                                    {{ $permission->short_name }}
                                                                </label>
                                                            </div>
                                                            <br />
                                                        @endif
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
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status"
                                aria-hidden="true"></span>
                            {{ __('admin.update') }}</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">
                            {{ trans('admin.close') }}
                        </button>
                    </div>
                </form>
                <!--/ Add role form -->
            </div>
        </div>
    </div>
</div>
<!--/ Add Role Modal -->



<!-- show Role Modal -->
<div class="modal fade" id="showRoleModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">

                <!-- Add role form -->
                <form action="#" method="" class="" novalidate>
                    @csrf
                    <input type="hidden" value="{{ $role->id }}" name="id">
                    <div class="col-12 mb-4">
                        <label class="form-label"
                            for="modalRoleName">{{ __('admin.user_management_role_name') }}</label><br>
                        <button class="btn btn-label-facebook">{{ $role->name }}</button>

                    </div>
                    <div class="col-12">
                        <h5>{{ __('admin.user_management_role_permissions') }}</h5>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap">

                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    @php
                                        $perm_role = $role->permissions->pluck('id');
                                    @endphp
                                    @foreach ($permission_gp as $gp)
                                        <tr>
                                            <td class="text-nowrap">
                                                <h6>{{ $gp->group_name }} :</h6>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @php $permissions  = Spatie\Permission\Models\Permission::where('group_id',$gp->group_id)->get(); @endphp
                                                    @php $per = Spatie\Permission\Models\Permission::whereIn('id', $perm_role)->pluck('id'); @endphp
                                                    @foreach ($permissions as $permission)
                                                        @if (Spatie\Permission\Models\Permission::where('id', $permission->id)->whereIn('id', $perm_role)->first())
                                                            <div class="form-check me-3 me-lg-5">
                                                                <label class="form-check-label"
                                                                    for="userManagementRead">
                                                                    <button
                                                                        class="btn btn-label-dribbble btn-sm px-2 py-0">{{ $permission->short_name }}</button>
                                                                </label>
                                                            </div>
                                                            <br />
                                                        @else
                                                        @endif
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
                </form>
                <!--/ Add role form -->
            </div>
        </div>
    </div>
</div>
<!--/ Add Role Modal -->
