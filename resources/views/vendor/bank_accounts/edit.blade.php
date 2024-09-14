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
                            <div class="card-body">
                                <form action="{{route('vendor.bank_accounts_update')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$bank_account->id}}">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">{{__('admin.bank_name')}}</label>
                                                <select  class="form-control" name="bank_id" id="">
                                                    @foreach ($banks as $bank)
                                                        <option value="{{$bank->id}}" {{$bank->id == $bank_account->id ? 'selected' : ''}}>{{$bank?->name_bank}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">{{__('admin.bank_name')}}</label>
                                                <input type="text" class="form-control" name="name_owner" value="{{$bank_account?->name_owner}}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Iban</label>
                                                <input type="text" name="iban_number" class="form-control" value="{{$bank_account?->iban_number}}">
                                            </div>
                                        </div>
                                    </div>

                                    <button class="my-4 btn btn-label-success">{{__('admin.update')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>
