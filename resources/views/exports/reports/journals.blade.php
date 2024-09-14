<table>
    <thead>
        <tr>
            <th>number_voucher</th>
            <th>debit</th>
            <th>credit</th>
            <th>statment</th>
            <th>account_name</th>
            <th>shipment_no/admin.cost_center</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entries as $entry)
            <tr>
                <td>
                    @if ($entry->journal_type_id == 1)
                        JV-{{ $entry->number }}
                    @elseif ($entry->journal_type_id == 2)
                        CR-{{ $entry->number }}
                    @elseif($entry->journal_type_id == 3)
                        CP-{{ $entry->number }}
                    @else
                        JS-{{ $entry->number }}
                    @endif
                </td>
                <td>{{ $entry->amount_debit ?? '' }}</td>
                <td>{{ $entry->amount_credit ?? '' }}</td>
                <td>
                    {{ $entry->statment ? 'بيان الصرف : ' . $entry->statment : '' }}
                    <span>{{ $entry->shipment?->company->name ?? '' }}</span>-{{ $entry->statment_for_journal ? 'بيان القيد : ' . $entry->statment_for_journal : '' }}
                </td>
                <td>{{ $entry?->debit_account_number }} {{ $entry?->debit_account_name }}
                    {{ $entry?->credit_account_number }} {{ $entry?->credit_account_name }}</td>
                <td>
                    {{ $entry->shipment ? 'ship#' . $entry?->shipment->shipment_refrence : '' }}-
                    {{ $entry?->costCenter?->car_name }}-
                    {{ $entry?->costCenter?->car_plate }}-{{ $entry?->branch?->branch_name }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<hr>

<table>
    <tr>
        <th>الرصيد السابق</th>
        <td>{{ $total_last_balande ?? 0 }}</td>
    </tr>
    <tr>
        <th>الرصيد المدين</th>
        <td>{{ $total_debit ?? 0 }}</td>
    </tr>
    <tr>
        <th>الرصيد الدائن</th>
        <td>{{ $total_credit ?? 0 }}</td>
    </tr>
    <tr>
        <th>الرصيد</th>
        <td>{{ $total_last_balande + $total_debit - $total_credit }}</td>
    </tr>
</table>
