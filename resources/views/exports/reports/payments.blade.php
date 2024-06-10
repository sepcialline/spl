<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
<table>
    <thead>


        <tr>
            {{-- <th>#</th> --}}
            <th>date</th>
            <th>in_branch</th>
            <th>shipment_refrence</th>
            <th>shipments_client_details</th>
            <th>vendors_company</th>
            {{-- <th>rider</th> --}}
            <th>payment_method</th>
            <th>shipment_amount</th>
            <th>delivery_fees</th>
            {{-- <th>due_amount_for_vendor</th> --}}
            {{-- <th>pay/dont_pay</th> --}}
        </tr>

    </thead>
    <tbody>
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->date }}</td>
                <td>{{ $payment->branch->branch_name }}</td>
                <td>{{ $payment->shipment->shipment_no }} #{{ $payment->shipment->shipment_refrence }}</td>
                <td>{{ $payment->shipment->Client->mobile }}-{{ $payment->shipment->Client->name }} -{{ $payment->shipment->emirate->name }} -{{ $payment->shipment->city->name }} -{{ $payment->shipment->delivered_address }}</td>
                <td>{{ $payment->company->name }}</td>
                {{-- <td>{{ $payment->Rider->name }}</td> --}}
                <td>{{ $payment->paymentMethod->name }} -{{ $payment->shipment?->Status->name }} </td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->delivery_fees }}</td>
                {{-- <td>{{ $payment->due_amount }}</td> --}}
                {{-- <td>{{ $payment->is_vendor_get_due == 0 ? 'no' : 'yes' }}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
