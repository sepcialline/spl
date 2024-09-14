<x-app-layout>
    @section('title')
        {{ __('admin.dashboard_dashboard') }}
    @endsection

    @section('VendorsCss')
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-2">
            <span class="text-muted fw-light">{{ __('admin.vendors_companies') }} /</span>
            {{ __('admin.service_request') }} / {{ __('admin.edit') }}
        </h4>

        <div class="row overflow-hidden">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-12">
                <ul class="timeline timeline-center mt-5">
                    <li class="timeline-item mb-md-4 mb-5">
                        <span class="timeline-indicator timeline-indicator-primary" data-aos="zoom-in"
                            data-aos-delay="200">
                            <i class="bx bx-paint"></i>
                        </span>
                        <div class="timeline-event card p-0" data-aos="fade-right">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="card-title mb-0">{{ $request->service->name }}</h6>
                                <div class="meta">
                                    <span
                                        class="badge rounded-pill bg-label-primary">#{{ $request->request_number }}</span>
                                    <span class="badge rounded-pill bg-label-warning">
                                        {{ __('admin.pending_approval') }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">

                                </p>
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <p class="text-muted mb-2">{{ $request->company->name }}</p>
                                        <ul class="list-unstyled users-list d-flex align-items-center avatar-group">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top" title="Vinnie Mostowy"
                                                class="avatar avatar-xs pull-up">

                                                @if ($request->guard_created == 'vendor')
                                                    @if ($created_by->avatar)
                                                        <img class="rounded-circle"
                                                            src="{{ asset('build/assets/img/uploads/vendors/' . $created_by->avatar) }}"
                                                            alt="Avatar" />
                                                    @else
                                                        <img class="rounded-circle"
                                                            src="{{ asset('build/assets/img/avatars/1.png') }}"
                                                            alt="Avatar" />
                                                    @endif
                                                @else
                                                    @if ($created_by->photo)
                                                        <img class="rounded-circle"
                                                            src="{{ asset('build/assets/img/uploads/avatars/' . $created_by->photo) }}"
                                                            alt="Avatar" />
                                                    @else
                                                        <img class="rounded-circle"
                                                            src="{{ asset('build/assets/img/avatars/1.png') }}"
                                                            alt="Avatar" />
                                                    @endif

                                                @endif
                                            </li>
                                            <li>
                                                <span>{{ $created_by->name }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-event-time">
                                {{ \Carbon\Carbon::parse($request->created_date)->format('Y-m-d') }}
                                <br>
                                {{ \Carbon\Carbon::parse($request->created_date)->format('H:m:i') }}
                            </div>
                        </div>
                    </li>
                    @if ($approved_by)
                        <li class="timeline-item mb-md-4 mb-5">
                            <span class="timeline-indicator timeline-indicator-success" data-aos="zoom-in"
                                data-aos-delay="200">
                                <i class="bx bx-question-mark"></i>
                            </span>
                            <div class="timeline-event card p-0" data-aos="fade-left">
                                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="card-title mb-0">{{ $request->service->name }}</h6>
                                    <div class="meta">
                                        <span
                                            class="badge rounded-pill bg-label-primary">#{{ $request->request_number }}</span>
                                        <span class="badge rounded-pill bg-label-success">
                                            {{ __('admin.approved') }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2">
                                        {{ $request?->notes }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <p class="text-muted mb-2">{{ $request->company->name }}</p>
                                            <ul class="list-unstyled users-list d-flex align-items-center avatar-group">
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" title="Vinnie Mostowy"
                                                    class="avatar avatar-xs pull-up">

                                                    @if ($request->guard_created == 'vendor')
                                                        @if ($approved_by->avatar)
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/uploads/vendors/' . $approved_by->avatar) }}"
                                                                alt="Avatar" />
                                                        @else
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/avatars/1.png') }}"
                                                                alt="Avatar" />
                                                        @endif
                                                    @else
                                                        @if ($approved_by->photo)
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/uploads/avatars/' . $approved_by->photo) }}"
                                                                alt="Avatar" />
                                                        @else
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/avatars/1.png') }}"
                                                                alt="Avatar" />
                                                        @endif

                                                    @endif
                                                </li>
                                                <li>
                                                    <span>{{ $approved_by->name }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-event-time">
                                    {{ \Carbon\Carbon::parse($request->approved_date)->format('Y-m-d') }}
                                    <br>
                                    {{ \Carbon\Carbon::parse($request->approved_date)->format('H:m:i') }}
                                </div>
                            </div>
                        </li>
                    @endif
                    @if ($declined_by)
                        <li class="timeline-item mb-md-4 mb-5">
                            <span class="timeline-indicator timeline-indicator-primary" data-aos="zoom-in"
                                data-aos-delay="200">
                                <i class="bx bx-paint"></i>
                            </span>
                            <div class="timeline-event card p-0" data-aos="fade-left">
                                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="card-title mb-0">{{ $request->service->name }}</h6>
                                    <div class="meta">
                                        <span
                                            class="badge rounded-pill bg-label-primary">#{{ $request->request_number }}</span>
                                        <span class="badge rounded-pill bg-label-danger">
                                            {{ __('admin.declined') }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2">
                                        {{ $request->cause }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <p class="text-muted mb-2">{{ $request->company->name }}</p>
                                            <ul class="list-unstyled users-list d-flex align-items-center avatar-group">
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" title="Vinnie Mostowy"
                                                    class="avatar avatar-xs pull-up">

                                                    @if ($request->guard_created == 'vendor')
                                                        @if ($declined_by->avatar)
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/uploads/vendors/' . $declined_by->avatar) }}"
                                                                alt="Avatar" />
                                                        @else
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/avatars/1.png') }}"
                                                                alt="Avatar" />
                                                        @endif
                                                    @else
                                                        @if ($declined_by->photo)
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/uploads/avatars/' . $declined_by->photo) }}"
                                                                alt="Avatar" />
                                                        @else
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/avatars/1.png') }}"
                                                                alt="Avatar" />
                                                        @endif

                                                    @endif
                                                </li>
                                                <li>
                                                    <span>{{ $declined_by->name }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-event-time">
                                    {{ \Carbon\Carbon::parse($request->declined_date)->format('Y-m-d') }}
                                    <br>
                                    {{ \Carbon\Carbon::parse($request->declined_date)->format('H:m:i') }}
                                </div>
                            </div>
                        </li>
                    @endif
                    @if ($delayed_by)
                        <li class="timeline-item mb-md-4 mb-5">
                            <span class="timeline-indicator timeline-indicator-warning" data-aos="zoom-in"
                                data-aos-delay="200">
                                <i class="bx bx-doughnut-chart"></i>
                            </span>
                            <div class="timeline-event card p-0" data-aos="fade-left">
                                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="card-title mb-0">{{ $request->service->name }}</h6>
                                    <div class="meta">
                                        <span
                                            class="badge rounded-pill bg-label-primary">#{{ $request->request_number }}</span>
                                        <span class="badge rounded-pill bg-label-dark">
                                            {{ __('admin.delayed') }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2">
                                        {{ $request?->cause }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <p class="text-muted mb-2">{{ $request->company->name }}</p>
                                            <ul
                                                class="list-unstyled users-list d-flex align-items-center avatar-group">
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" title="Vinnie Mostowy"
                                                    class="avatar avatar-xs pull-up">

                                                    @if ($request->guard_created == 'vendor')
                                                        @if ($delayed_by->avatar)
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/uploads/vendors/' . $delayed_by->avatar) }}"
                                                                alt="Avatar" />
                                                        @else
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/avatars/1.png') }}"
                                                                alt="Avatar" />
                                                        @endif
                                                    @else
                                                        @if ($delayed_by->photo)
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/uploads/avatars/' . $delayed_by->photo) }}"
                                                                alt="Avatar" />
                                                        @else
                                                            <img class="rounded-circle"
                                                                src="{{ asset('build/assets/img/avatars/1.png') }}"
                                                                alt="Avatar" />
                                                        @endif

                                                    @endif
                                                </li>
                                                <li>
                                                    <span>{{ $delayed_by->name }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-event-time">
                                    {{ \Carbon\Carbon::parse($request->delayed_date)->format('Y-m-d') }}
                                    <br>
                                    {{ \Carbon\Carbon::parse($request->delayed_date)->format('H:m:i') }}
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.services_company_update', $request->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{ __('admin.status') }}</label>
                                        <select id="status" name="status" class="form-control">
                                            <option value="" disabled selected>{{ __('admin.please_select') }}
                                            </option>
                                            <option value="2">{{ __('admin.approved') }}</option>
                                            <option value="3">{{ __('admin.declined') }}</option>
                                            <option value="4">{{ __('admin.delayed') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comment">{{ __('admin.note:') }}</label>
                                        <textarea id="comment" name="notes" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="comment">{{ __('admin.cause') }}</label>
                                    <textarea id="comment" name="cause" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-label-facebook">{{ __('admin.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @section('VendorsJs')
    @endsection
</x-app-layout>
