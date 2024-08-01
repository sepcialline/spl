<x-app-layout>
    @section('title')
        Dashboard
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card p-4">
                <div class="d-flex justify-content-sm-between align-items-sm-center">

                    <div class="d-flex align-items-sm-center">
                        <h5 class="card-header"> {{ __('admin.merchant_list') }} </h5>
                        @can('admin-shopify-refresh')
                            <span class="">
                                <a href="{{ route('admin.shopify_settings') }}"
                                    class="btn btn-success btn-sm ml-2">{{ __('admin.refresh') }}</a>
                            </span>
                        @endcan

                    </div>

                    {{-- @can('admin-shopify-add-merchant')
                        <a href="{{ route('admin.shopify_create') }}"
                            class="btn btn-secondary">{{ __('admin.add_merchant') }}</a>
                    @endcan --}}

                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <!-- Update Password Modal -->

                    <!--/ Update Password Modal -->
                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('admin.name') }}</th>
                                <th>{{ __('admin.count') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>

                        @foreach ($data as $row)
                        {{-- @php $company = App\Models\VendorCompany::where('id',$row->company_id)->first(); @endphp --}}
                        {{-- <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" /> --}}

                            <tr>
                                <td>{{ $row->name ?? '' }}</td>
                                <td>{{ $row->count->count ?? '0' }}</td>
                                <td>
                                  @include('admin.shopify.includes.modals',['company'=>$row])

                                    {{-- <a href="edit/{{ $row['id'] }}"
                                        class="btn btn-label-secondary">{{ __('admin.branch_action_edit') }}</a>

                                    <a id="delete" class="btn btn-label-danger delete"
                                        data-url="{{ route('admin.branch_delete', $row['id']) }}">{{ __('admin.branch_action_delete') }}</a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
