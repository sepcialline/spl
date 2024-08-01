<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<table>
    <thead>
        <tr>
            <th>date</th>
            <th>in_branch</th>
            <th>shipment_refrence</th>
            <th>shipments_client_details</th>
            <th>vendors_company</th>
            <th>rider</th>
            <th>payment_method</th>
            <th>shipment_amount</th>
            <th>delivery_fees</th>
            <th>due_amount_for_vendor</th>
            <th>pay/dont_pay</th>
        </tr>

    </thead>
    <tbody>
        @php $sum_due = 0 @endphp
        @foreach ($payments as $payment)
            @php $sum_due = $sum_due +$payment->due_amount;  @endphp
            <tr>
                <td>{{ $payment->date }}</td>
                <td>{{ $payment->branch->branch_name }}</td>
                <td>{{ $payment->shipment->shipment_no }} #{{ $payment->shipment->shipment_refrence }}</td>
                <td>{{ $payment->shipment->Client->mobile }}-{{ $payment->shipment->Client->name }}
                    -{{ $payment->shipment->emirate->name }} -{{ $payment->shipment->city->name }}
                    -{{ $payment->shipment->delivered_address }}</td>
                <td>{{ $payment->company->name }}</td>
                <td>{{ $payment->Rider->name }}</td>
                <td>{{ $payment->paymentMethod->name }} -{{ $payment->shipment?->Status->name }} </td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->delivery_fees }}</td>
                <td>{{ $payment->due_amount }}</td>
                <td>{{ $payment->is_vendor_get_due == 0 ? 'no' : 'yes' }}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $sum_due }}</td>
            <td></td>
        </tr>
    </tbody>
</table>


<table>

    <tr>
        <th>total</th>
        <td>{{ $total }} AED</td>

        <th>net income</th>
        <td>{{ $net_income }} AED</td>

        <th>vendor account</th>
        <td>{{ $vendor_account }} AED</td>
    </tr>
    <tr>
        <th>cash on delivery</th>
        <td>{{ $cash_on_delivery }} AED</td>

        <th>income</th>
        <td>{{ $cod_sp_income }} AED</td>

        <th>vendor account</th>
        <td>{{ $cod_vendor_balance }} AED</td>
    </tr>


    <tr>
        <th>transfer to Bank</th>
        <td>{{ $transfer_to_Bank }} AED</td>

        <th>income</th>
        <td>{{ $tr_bank_sp_income }} AED</td>

        <th>vendor account</th>
        <td>{{ $tr_bank_vendor_balance }} AED</td>
    </tr>

    <tr>
        <th>transfer to vendor_company</th>

        <td> {{ $transfer_to_vendor_company }} AED</td>
    </tr>




</table>
