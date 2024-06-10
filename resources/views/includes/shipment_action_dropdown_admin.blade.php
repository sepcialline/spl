<div class="dropdown">

    <button class="btn btn-label-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton1"
        data-bs-toggle="dropdown" aria-expanded="false">
        {{ __('admin.action') }}
    </button>

    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        @can('admin-Shipment-delete')
            <li><button class="dropdown-item" id="delete_shipment">{{ __('admin.delete') }}</button></li>
        @endcan
        @if (auth()->user()->can('admin-Shipment-edit') ||
                auth()->user()->can('admin-Shipment-assign rider') ||
                auth()->user()->can('admin-Shipment-print') ||
                auth()->user()->can('admin-Shipment-change-status'))
            <li><a class="dropdown-item" href="{{ route('admin.shipment_actions', ['id' => $shipment->id]) }}"
                    id="">{{ __('admin.actions') }}</a></li>
        @endif

    </ul>
</div>
