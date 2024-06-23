<table>
    <thead>
        <tr>
            <th>تسلسل</th>
            <th>تاريخ التوصيل</th>
            <th>رقم الشحنة /الرقم المرجعي</th>
            <th>السائق</th>
            <th>الزبون</th>
            <th>عنوان الزبون</th>
            <th>التاجر</th>
            <th>طريقة الدفع</th>
            <th>الحالة</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($shipments as $shipment)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $shipment->delivered_date ?? '' }}</td>
                <td>{{ $shipment->shipment_no ?? '' }} / #{{ $shipment->shipment_refrence ?? '' }}</td>
                <td>{{ $shipment->Rider->name ?? 'لا يوجد' }}</td>
                <td>{{ $shipment->Client->name ?? '' }} / {{ $shipment->Client?->mobile ?? '' }}</td>
                <td>{{ $shipment->emirate->name ?? '' }} / {{ $shipment->city->name ?? '' }} {{ $shipment->delivered_address ?? '' }}</td>
                <td>{{ $shipment->Company->name ?? '' }}</td>
                <td>{{ $shipment->paymentMethod->name ?? '' }}</td>
                <td>{{ $shipment->Status->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
