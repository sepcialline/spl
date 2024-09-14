<x-vendor-layout>
    @section('title')
        {{ __('admin.dashboard_dashboard') }}
    @endsection

    @section('VendorsCss')
        <!-- Page CSS -->
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/css/pages/page-profile.css') }}" />
        <!-- Helpers -->
    @endsection
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <div class="card-header py-4">
                                <div class="d-flex justify-content-between">
                                    <h4>{{ __('admin.service_request') }}</h4>
                                    <a href="{{ route('vendor.services.create', $company_id) }}"
                                        class="btn btn-label-facebook">{{ __('admin.accounts_add_new') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('admin.shipments_company_name') }}</th>
                                                <th>{{ __('admin.service') }}</th>
                                                <th>{{ __('admin.date') }}</th>
                                                <th>{{ __('admin.status') }}</th>
                                                <th>{{ __('admin.shipment_notes') }}</th>
                                                {{-- <th>{{__('admin.actions')}}</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i=1; @endphp
                                            @foreach ($requests as $service)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $service?->company?->name }}</td>
                                                <td>{{ $service?->service?->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($service?->created_date)->format('Y-m-d h:m:i') }}
                                                </td>
                                                <td>
                                                    @if ($service->approved_by != Null)
                                                        <span class="text-success">
                                                            {{ __('admin.approved') }}</span>
                                                    @elseif($service->declined_by != Null)
                                                        <span class="text-danger">
                                                            {{ __('admin.declined') }}</span>
                                                    @elseif($service->delayed_by != Null)
                                                        <span class="text-dark">
                                                            {{ __('admin.delayed') }}</span>
                                                    @else
                                                        <span class="text-warning">
                                                            {{ __('admin.pending_approval') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($service->approved_by != Null)
                                                    {{$service->notes}}
                                                @elseif($service->declined_by != Null)
                                                {{$service->cause}}
                                                @elseif($service->delayed_by != Null)
                                                {{$service->cause}}
                                                @else
                                                    <span class="text-warning">
                                                        {{ __('admin.pending_approval') }}</span>
                                                @endif
                                                </td>
                                                {{-- <td>
                                                    <a class="btn btn-xs btn-label-secondary" href="{{route('admin.services_company_show',$service->id)}}">{{__('admin.show')}}</a>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>
