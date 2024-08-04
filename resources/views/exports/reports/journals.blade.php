<table>
    <thead>
        <tr>
            <th>number_voucher</th>
            <th>debit</th>
            <th>credit</th>
            <th>statment</th>
            <th>account_name</th>
            <th>shipment_no/cost_center</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entries as $entry)
            @php
                $count_of_line = App\Models\AccountingEntries::where('number', $entry->number)
                    ->select('number')
                    ->get();
            @endphp
            <tr>
                <td>{{ $entry->number }}</td>
                <td>{{ $entry->amount_debit ?? '' }}</td>
                <td>{{ $entry->amount_credit ?? '' }}</td>
                <td>{{ $entry->statment ?? '' }}</td>
                <td>{{ $entry?->debit_account_number }} {{ $entry?->debit_account_name }}
                    {{ $entry?->credit_account_number }} {{ $entry?->credit_account_name }} </td>
                <td>{{ $entry->shipment ? 'ship#' . $entry?->shipment->shipment_refrence : '' }}
                    {{ $entry?->cost_center?->car_name }} {{ $entry?->cost_center?->car_plate }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table>
    <tr>
        <td colspan="2">مجموع القيم</td>
    </tr>
    <tr>
        <td>إجمالي المدين</td>
        <td>{{ $total_debit ?? 0 }}</td>
    </tr>
    <tr>
        <td>إجمالي الدائن</td>
        <td>{{ $total_credit ?? 0 }}</td>
    </tr>
</table>

<table>
    <tr><th>المحصلة</th></tr>
    <tr><td>{{ $total_balance ?? 0 }}</td></tr>
</table>
