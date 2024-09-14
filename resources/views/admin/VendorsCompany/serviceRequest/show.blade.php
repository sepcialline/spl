<x-app-layout>

    @section('title')
        {{ __('admin.vendors_companies') }} | {{ __('admin.service_request') }}
    @endsection

    @section('VendorsCss')
    @endsection
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-2">
                <span class="text-muted fw-light">{{ __('admin.vendors_companies') }} /</span>
                {{ __('admin.service_request') }} / {{ __('admin.show') }}
            </h4>

            <div class="row overflow-hidden">
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
                                    <div
                                        class="card-header d-flex justify-content-between align-items-center flex-wrap">
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
                                                <ul
                                                    class="list-unstyled users-list d-flex align-items-center avatar-group">
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
                                    <div
                                        class="card-header d-flex justify-content-between align-items-center flex-wrap">
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
                                                <ul
                                                    class="list-unstyled users-list d-flex align-items-center avatar-group">
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
                                    <div
                                        class="card-header d-flex justify-content-between align-items-center flex-wrap">
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
        </div>


        @section('VendorsJS')
            <!-- Page JS -->
            <script src="{{ asset('build/assets/js/forms-selects.js') }}"></script>
            <script src="{{ asset('build/assets/js/forms-tagify.js') }}"></script>
            <script src="{{ asset('build/assets/js/forms-typeahead.js') }}"></script>
            <script src="{{ asset('build/assets/js/forms-pickers.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                $(document).on('click', '#delete_shipment', function() {
                    var id = $(this).closest('tr').find('#id').val();
                    Swal.fire({
                        title: "{{ __('admin.msg_are_you_sure_for_delete') }}",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "{{ __('admin.yes') }}"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'GET',
                                url: "{{ route('admin.shipments_delete') }}",
                                data: {
                                    id: id
                                },
                                success: function(res) {
                                    console.log(res);
                                    if (res.code == 200) {
                                        Swal.fire({
                                            title: "{{ __('admin.deleted') }}",
                                            text: "{{ __('admin.msg_success_delete') }}",
                                            icon: "success"
                                        });
                                        $("#content_table").load(location.href + " #content_table");
                                    }

                                }

                            })

                        }
                    });
                });
            </script>

            <script>
                function submitForm() {
                    document.getElementById("clk").disabled = true;
                }
            </script>
        @endsection
</x-app-layout>
