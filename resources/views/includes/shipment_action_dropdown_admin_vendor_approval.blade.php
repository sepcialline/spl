<div class="dropdown">
    <button class="btn btn-label-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton1"
        data-bs-toggle="dropdown" aria-expanded="false">
        {{ __('admin.action') }}
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><button class="dropdown-item" id="delete_shipment">{{ __('admin.delete') }}</button></li>
        <li><a class="dropdown-item" href="{{route('admin.shipment_actions',['id'=>$shipment->id])}}"  id="">{{ __('admin.actions') }}</a></li>
    </ul>
</div>


