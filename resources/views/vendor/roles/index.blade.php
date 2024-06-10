<x-vendor-layout>
    @section('title')
        {{ __('admin.user_management_Role_list') }}
    @endsection
    @section('VendorsCss')
        <style>
            .my-input:checked {
                background-color: rgb(0 88 255) !important;
                border-color: rgb(0 88 255) !important;
            }
        </style>
    @endsection


    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-2">{{ __('admin.user_management_role_managment') }}</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Role cards -->
        <div class="row g-4">
            @foreach ($roles as $role)
                @php  $employees = App\Models\Employee::role("$role->name")->get(); @endphp
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">

                                <h6 class="fw-normal"> {{ count($employees) }} {{ __('admin.user_management_users') }}
                                </h6>
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    @foreach ($employees as $employee)
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            title="{{ $employee->name }}" class="avatar avatar-sm pull-up">
                                            @if ($employee->photo)
                                                <img class="rounded-circle"
                                                    src="{{ asset('/build/assets/img/uploads/avatars/' . $employee->photo) }}"
                                                    alt="Avatar" />
                                            @else
                                                <img class="rounded-circle"
                                                    src="{{ asset('/build/assets/img/profile/avatar.png') }}">
                                            @endif

                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                            <div class="d-flex  justify-content-between align-items-end">
                                <div class="role-heading">
                                    <h4 class="mb-1">{{ $role->name }}</h4>
                                    {{-- <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal"
                                        class="role-edit-modal"><small>Edit Role</small></a> --}}
                                </div>
                                {{-- <a href="javascript:void(0);" class="text-muted"><i class="bx bx-copy"></i></a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <div class="col-4">
                @include('employee.roles.includes.add')
            </div>
        </div>


        <div class="col-12 my-4">

            <!-- Role Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table table-striped border-top">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.user_management_Role') }}</th>
                                <th>{{ __('admin.user_management_users') }}</th>
                                <th>{{ __('admin.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($roles as $role)
                                @php  $employees = App\Models\Employee::role("$role->name")->get(); @endphp

                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($employees as $employee)
                                            <button class="btn btn-sm btn-primary">{{ $employee->name }} </button>
                                        @endforeach
                                    </td>
                                    <td>@include('employee.roles.includes.actions', ['role', $role])</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
            <!--/ Role Table -->
        </div>
    </div>

    </div>

    @section('VendorsJS')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script type="text/javascript">
            $('.confirm-button').click(function(event) {
                var form = $(this).closest("form");
                event.preventDefault();
                swal({
                        title: `{{ __('admin.msg_are_you_sure_for_delete') }}`,
                        text: "",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });
            });
        </script>
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict'

                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.querySelectorAll('.needs-validation')

                // Loop over them and prevent submission
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>

        <script>
            // $(document).ready(function() {
            $(document).on('click', '#selectAllAdd', function() {
                $('input:checkbox.selectAdd').not(this).prop('checked', this.checked);
            });
            $(document).on('click', '#selectAllEdit', function() {
                $('input:checkbox.selectEdit').not(this).prop('checked', this.checked);
            });
            $(document).on('submit', 'form', function() {
                $('button').attr('disabled', 'disabled');
                $(".spinner-border").removeClass("d-none");
            });
            // });
        </script>
    @endsection
</x-vendor-layout>
