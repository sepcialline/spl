<x-app-layout>
    @section('title')
        {{ __('admin.vendors_management') }} | {{ __('admin.vendor_account') }}
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
        {{-- select2 --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light"> {{ __('admin.vendors_management') }} / </span>
            {{ __('admin.vendor_account') }}
        </h4>


        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4 d-flex align-items-center p-2">
                    @if ($vendor->avatar)
                        <img src="{{ asset('build/assets/img/uploads/vendors/' . $vendor->avatar) }}"
                            class="img-fluid rounded-start" alt="...">
                    @else
                        <img src="{{ asset('build/assets/img/uploads/avatars/1.png') }}" class="img-fluid rounded-start"
                            alt="...">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $vendor?->name }}</h5>
                        <p class="card-text">{{ $vendor?->email }}</p>
                        <p class="card-text"><small class="text-muted">{{ $vendor?->mobile }}</small></p>
                        <div class="flex justify-between">
                            <a class="btn btn-xs btn-label-success"
                                href="{{ route('admin.vendors_edit', $vendor->id) }}">{{ __('admin.edit') }}</a>
                            @hasrole('Super Admin', 'admin')
                                @if ($vendor->status == 0)
                                    <a class="btn btn-xs btn-label-info"
                                        href="{{ route('admin.vendors_edit', $vendor->id) }}">{{ __('admin.active_it') }}</a>
                                @else
                                    <a class="btn btn-xs btn-label-info"
                                        href="{{ route('admin.vendors_edit', $vendor->id) }}">{{ __('admin.stop_it') }}</a>
                                @endif
                            @endhasrole
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-label-danger" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                {{ __('admin.change_password') }}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.vendors_change_password') }}" method="post">
                                            <div class="modal-body">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $vendor->id }}">
                                                <input type="text" name="password" id=""
                                                    class="form-control">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('admin.company_list') }}</h3>
                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <table id="table1" class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.vendors_companies_company_name') }}</th>
                                <th>{{ __('admin.vendors_companies_company_owner_name') }}</th>
                                <th>{{ __('admin.branch_branch_name') }}</th>
                                <th>{{ __('admin.status') }}</th>
                                <th>{{ __('admin.branch_branch_actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($vendor->companies as $company)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                title="Lilian Fuller">
                                                @if ($company->logo)
                                                    <img src="{{ asset('/build/assets/img/uploads/logos/' . $company->logo) }}"
                                                        alt="" class="rounded-circle" />
                                                @else
                                                    <img src="{{ asset('/build/assets/img/uploads/avatars/avatar.png') }}"
                                                        alt="" class="rounded-circle" />
                                                @endif
                                            </li>
                                            <li>{{ $company->name }}</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                title="Lilian Fuller">
                                                @if (!empty($company['owner']['avatar']))
                                                    <img src="{{ asset('/build/assets/img/uploads/vendors/' . $company->owner->avatar) }}"
                                                        alt="" class="rounded-circle" />
                                                @else
                                                    <img src="{{ asset('/build/assets/img/uploads/avatars/avatar.png') }}"
                                                        alt="" class="rounded-circle" />
                                                @endif
                                            </li>
                                            <li>
                                                @if (isset($company->owner->name))
                                                    {{ $company->owner->name }}
                                                @else
                                                    <span class="text-danger">اربط الشركة بمالكها</span>
                                                @endif
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        @if ($company->branch)
                                            {{ $company->branch->branch_name }}
                                        @else
                                            <span class="text-danger">اربط الشركة بالفرع</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('admin-Employees-change-status')
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input status"
                                                    data-url="{{ route('admin.vendors_company_update_status', $company['id']) }}"
                                                    name="status" id="status"
                                                    {{ $company['status'] ? 'checked' : !'checked' }} />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="bx bx-check"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="bx bx-x"></i>
                                                    </span>
                                                </span>
                                                {{-- <span class="switch-label">Primary</span> --}}
                                            </label>
                                        @endcan

                                        {{-- {{ $item->status }} --}}
                                    </td>
                                    <td>
                                        @can('admin-Company-edit')
                                            <a href="{{ route('admin.vendors_company_edit', $company->id) }}"
                                                class="btn btn-sm btn-label-success">{{ __('admin.edit') }}</a>
                                        @endcan

                                        @can('admin-Company-delete')
                                            <a data-url="{{ route('admin.vendors_company_delete', $company->id) }}"
                                                class="btn btn-sm btn-label-danger delete">{{ __('admin.delete') }}</a>
                                        @endcan
                                        @can('admin-Company-show')
                                            <a href="{{ route('admin.vendors_company_show', $company->id) }}"
                                                class="btn btn-sm btn-label-dark">{{ __('admin.show') }}</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="row my-4">
            <div class="card">
                <div class="card-header">
                    <h3>طلبات التاجر</h3>
                </div>
                <div class="card-body">
                    جاري العمل عليها
                </div>
            </div>
        </div>







    </div>
    <!-- / Content -->
    @section('VendorsJS')
        {{-- Form Valid --}}
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
                $('.js-example-basic-multiple').select2();
            });
        </script>
    @endsection

</x-app-layout>
