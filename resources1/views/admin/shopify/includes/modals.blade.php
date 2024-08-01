@can('admin-shopify-config')
<a href="" data-bs-toggle="modal" data-bs-target="#config_shopify_{{$company->id}}"
    class="btn btn-label-warning">{{ __('admin.config') }}</a>
@endcan
@can('admin-shopify-show')
<a href="{{route('admin.shopify_show',[$company->id])}}"
    class="btn btn-label-dark">{{ __('admin.branch_action_show') }}</a>
@endcan


 <div class="modal fade" id="config_shopify_{{$company->id}}" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
         <div class="modal-content p-3 p-md-5">
             <div class="modal-body">
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 <div class="text-center mb-4">
                     <h3 class="mb-4">{{ __('admin.config_shopify') }}</h3>
                 </div>

                 <form id="config_shopifyForm" class="row g-3 mt-3" method="POST" class=" needs-validation" novalidate
                     action="{{ route('admin.shopify_config') }}">
                     @csrf
                     <input type="hidden" id="company_id" name="company_id" value="{{ $row['id'] ?? '' }}" />
                     <div class="col-12">
                         <label class="form-label" for="modalEnableOTPPhone">{{ __('admin.store_name') }}</label>

                         <div class="input-group input-group-merge">
                             <input type="text" id="store_name" name="store_name"
                                 value="{{ $row->config->store_name ?? '' }}" class="form-control"
                                 placeholder="Store Name" />
                         </div>

                     </div>

                     <div class="col-12">
                         <label class="form-label" for="modalEnableOTPPhone">{{ __('admin.access_token') }}</label>
                         {{-- <input type="hidden" id="id" name="id" value="{{ $data['id'] }}"/> --}}
                         <div class="input-group input-group-merge">
                             <input type="text" id="access_token" name="access_token" class="form-control"
                                 value="{{ $row->config->access_token ?? '' }}" placeholder="Access Token" />
                         </div>

                     </div>
                     <div class="col-12 mt-2">
                         <button type="submit" class="btn btn-primary me-sm-3 me-1">{{ __('admin.send') }}</button>
                         <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                             aria-label="Close">
                             {{ __('admin.close') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
