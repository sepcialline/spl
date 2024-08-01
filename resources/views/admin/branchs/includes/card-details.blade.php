<div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
    <!-- User Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="user-avatar-section">
                <div class="d-flex align-items-center flex-column">
                    <img class="img-fluid rounded my-4"
                        src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}"
                        height="110" width="110" alt="User avatar" />
                    <div class="user-info text-center">
                        <h5 class="mb-2">{{ $branch->branch_name }}</h5>
                        <span class="badge bg-label-secondary">{{ $branch?->emirate?->name }}</span><br>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge bg-label-primary p-2 rounded"><i
                        class="bx bx-money-withdraw bx-sm"></i></span>
                <div>
                    <h5 class="mb-0">{{$branch->revenuse_account ?? '-'}}</h5>
                    <span>{{__('admin.revenue_account')}}</span>
                </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge bg-label-primary p-2 rounded"><i
                        class="bx bx-money-withdraw bx-sm"></i></span>
                <div>
                    <h5 class="mb-0">{{$branch->vat_on_sales ?? '-'}}</h5>
                    <span>{{__('admin.vat_on_sales')}}</span>
                </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge bg-label-primary p-2 rounded"><i
                        class="bx bx-money-withdraw bx-sm"></i></span>
                <div>
                    <h5 class="mb-0">{{$branch->vat_on_purchase ?? '-'}}</h5>
                    <span>{{__('admin.vat_on_purchase')}}</span>
                </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge bg-label-primary p-2 rounded"><i
                        class="bx bx-money-withdraw bx-sm"></i></span>
                <div>
                    <h5 class="mb-0">{{$branch->expense_account ?? '-'}}</h5>
                    <span>{{__('admin.exp_account')}}</span>
                </div>
            </div>
            <div class="d-flex justify-content-around flex-wrap my-4 py-3">
                <div class="d-flex align-items-start me-4 mt-3 gap-3">
                    <span class="badge bg-label-primary p-2 rounded"><i
                            class="bx bx-check bx-sm"></i></span>
                    <div>
                        <h5 class="mb-0">123</h5>
                        <span>some thing</span>
                    </div>
                </div>
                <div class="d-flex align-items-start mt-3 gap-3">
                    <span class="badge bg-label-primary p-2 rounded"><i
                            class="bx bx-customize bx-sm"></i></span>
                    <div>
                        <h5 class="mb-0">4123</h5>
                        <span>some thing</span>
                    </div>
                </div>
            </div>
            <h5 class="pb-2 border-bottom mb-4">{{ __('admin.details') }}</h5>
            <div class="info-container">
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <span class="fw-bold me-2">{{ __('admin.email') }} :</span>
                        <span> {{ $branch?->branch_email }}</span>
                    </li>

                    <li class="mb-3">
                        <span class="fw-bold me-2">{{ __('admin.status') }}:</span>
                        <span
                            class="badge bg-label-{{ $branch->status = 1 ? 'success' : 'danger' }}">{{ $branch->status = 1 ? __('admin.active') : __('admin.deactivate') }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-bold me-2">{{ __('admin.mobile') }} :</span>
                        <span>{{ $branch?->branch_mobile }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-bold me-2">{{ __('admin.landline') }} :</span>
                        <span>{{ $branch?->branch_landline }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-bold me-2">{{ __('admin.emirate') }}:</span>
                        <span>{{ $branch?->emirate?->name }}</span>
                    </li>
                </ul>
                <div class="d-flex justify-content-center pt-3">
                    {{-- <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser"
                        data-bs-toggle="modal">Edit</a> --}}
                    <a href="javascript:;" class="btn btn-label-danger suspend-user disabled">Suspended</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Card -->
</div>
