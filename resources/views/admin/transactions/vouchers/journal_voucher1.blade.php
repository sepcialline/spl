<x-app-layout>
    @section('title')
        {{ __('admin.transactions') }} | {{ __('admin.journal_voucher') }}
    @endsection

    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                border: 1px solid #000;
            }

            table th,
            table td {
                border: 1px solid #000;
                padding: 8px;
                text-align: center;
                font-size: 14px;
                font-weight: normal;
            }

            table th {
                background-color: #f2f2f2;
                font-weight: bold;
            }

            .add-btn,
            .delete-btn {
                margin-top: 10px;
                padding: 8px 16px;
                font-size: 14px;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
            }

            .delete-btn:disabled {
                background-color: #ccc;
                cursor: not-allowed;
            }

            .add-btn:hover,
            .delete-btn:hover {
                background-color: #45a049;
            }
        </style>
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.transactions') }} / </span>
            {{ __('admin.journal_voucher') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.account.store_journal_voucher') }}" method="post" id="journalForm"
                    class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="row mt-2">
                        <div class="form-group col-4">
                            <label for="exampleFormControlInput1">{{ __('admin.date') }}</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="form-group col">
                            <label for="exampleFormControlInput1">{{ __('admin.statment_for_journal') }}</label>
                            <textarea name="statment_for_journal" id="statment_for_journal" cols="50" rows="1" class="form-control"
                                required></textarea>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th style="width: 16%">{{ __('admin.credit') }}/ {{ __('admin.amount') }}</th>
                                <th style="width: 16%">{{ __('admin.debit') }}/ {{ __('admin.amount') }}</th>
                                <th style="width: 14.5%">{{ __('admin.statment') }}</th>
                                <th style="width: 14.5%">{{ __('admin.in_branch') }}</th>
                                <th style="width: 16%">{{ __('admin.cost_center') }}</th>
                                <th style="width: 10%">{{ __('admin.shipment_no') }}</th>
                                <th style="width: 2%">#</th>
                            </tr>
                        </thead>
                        <tbody id="entries">
                            <tr class="entry">
                                <td style="width: 16%">
                                    <select name="credit_account_id[]" class="js-example-basic-single">
                                        <option value="" selected disabled>{{ __('admin.please_select') }}
                                        </option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->account_name }} |
                                                {{ $account->account_code }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <input type="number" placeholder="example 100" class="form-control credit-amount"
                                        step="0.01" name="credit_amount[]">
                                </td>
                                <td style="width: 16%">
                                    <select name="debit_account_id[]" class="js-example-basic-single">
                                        <option value="" selected disabled>{{ __('admin.please_select') }}
                                        </option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->account_name }} |
                                                {{ $account->account_code }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <input type="number" placeholder="example 100" class="form-control debit-amount"
                                        step="0.01" name="debit_amount[]">
                                </td>
                                <td style="">
                                    <textarea name="statments[]" placeholder="هنا أكتب البيان" class="form-control" cols="30" rows="3" required></textarea>
                                </td>
                                <td>
                                    <select name="branch_id[]" class="js-example-basic-single">
                                        <option value="" selected >{{ __('admin.please_select') }}
                                        </option>
                                        @foreach ($branchs as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="">
                                    <select name="cost_centers[]" class="js-example-basic-single">
                                        <option value="" selected>{{ __('admin.please_select') }}
                                        </option>
                                        @foreach ($cars as $car)
                                            <option value="{{ $car->id }}">{{ $car->car_name }} |
                                                {{ $car->car_plate }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style=""><input type="text" class="form-control"
                                        name="shipment_refrence[]"></td>
                                <td style=""><button type="button" class="delete-btn btn btn-danger btn-sm p-1"
                                        onclick="deleteRow(this)"><i class="fa fa-delete-left"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="add-btn btn btn-primary btn-sm" onclick="addEntry()">إضافة سطر
                        جديد</button>
                    <br>
                    <div class="form-group col-12">
                        <label for="totalCredit">مجموع الدائن: </label>
                        <span id="totalCredit">0.00</span>
                    </div>
                    <div class="form-group col-12">
                        <label for="totalDebit">مجموع المدين: </label>
                        <span id="totalDebit">0.00</span>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm" id="submit-btn" disabled>حفظ القيود</button>
                    <div id="error-message" class="text-danger"></div>
                </form>
            </div>
        </div>
    </div>

    @section('VendorsJS')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
                $(document).on('select2:open', () => {
                    document.querySelector('.select2-search__field').focus();
                });

                // Add focus event listener to open Select2 dropdown
                $('.select2').on('focus', function() {
                    $(this).select2('open');
                });

                function calculateTotals() {
                    let totalCredit = 0;
                    let totalDebit = 0;

                    $('.credit-amount').each(function() {
                        totalCredit += parseFloat($(this).val()) || 0;
                    });

                    $('.debit-amount').each(function() {
                        totalDebit += parseFloat($(this).val()) || 0;
                    });

                    $('#totalCredit').text(totalCredit.toFixed(2));
                    $('#totalDebit').text(totalDebit.toFixed(2));

                    if (totalCredit === totalDebit) {
                        $('#submit-btn').prop('disabled', false);
                        $('#error-message').text('');
                    } else {
                        $('#submit-btn').prop('disabled', true);
                        $('#error-message').text('يجب أن يكون مجموع الدائن والمدين متساوي.');
                    }
                }

                $(document).on('input', '.credit-amount, .debit-amount', calculateTotals);
                $(document).on('change', '.js-example-basic-single', calculateTotals);

                calculateTotals(); // Call once to set initial state
            });

            function addEntry() {
                const entriesTable = document.getElementById('entries');
                const newRow = document.createElement('tr');
                newRow.classList.add('entry');
                newRow.innerHTML = `
                    <td style="width: 16%">
                        <select name="credit_account_id[]" class="js-example-basic-single">
                            <option value="" selected disabled>{{ __('admin.please_select') }}</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->account_name }} | {{ $account->account_code }}</option>
                            @endforeach
                        </select>
                        <br>
                        <input type="number" placeholder="example 100" class="form-control credit-amount" step="0.01" name="credit_amount[]">
                    </td>
                    <td style="width: 16%">
                        <select name="debit_account_id[]" class="js-example-basic-single">
                            <option value="" selected >{{ __('admin.please_select') }}</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->account_name }} | {{ $account->account_code }}</option>
                            @endforeach
                        </select>
                        <br>
                        <input type="number" placeholder="example 100" class="form-control debit-amount" step="0.01" name="debit_amount[]">
                    </td>
                    <td style="width: 29%">
                        <textarea name="statments[]" placeholder="هنا أكتب البيان" class="form-control" cols="30" rows="3" required></textarea>
                    </td>
                    <td>
                        <select name="branch_id[]" class="js-example-basic-single">
                                        <option value="" selected disabled>{{ __('admin.please_select') }}</option>
                                        @foreach ($branchs as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                        @endforeach
                        </select>
                    </td>
                    <td style="width: 16%">
                        <select name="cost_centers[]" class="js-example-basic-single">
                            <option value="" selected>{{ __('admin.please_select') }}</option>
                            @foreach ($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->car_name }} | {{ $car->car_plate }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td style="width: 10%"><input type="text" class="form-control" name="shipment_refrence[]"></td>
                    <td style="width: 2%"><button type="button" class="delete-btn btn btn-danger btn-sm p-1" onclick="deleteRow(this)"><i class="fa fa-delete-left"></i></button></td>
                `;
                entriesTable.appendChild(newRow);
                $('#entries').find('.js-example-basic-single').select2();
                checkDeleteButton();
            }

            function deleteRow(btn) {
                const row = btn.closest('tr');
                row.parentNode.removeChild(row);
                checkDeleteButton();
                calculateTotals(); // Recalculate totals after row deletion
            }

            function checkDeleteButton() {
                const deleteButtons = document.querySelectorAll('.delete-btn');
                if (deleteButtons.length === 1) {
                    deleteButtons[0].disabled = true; // تعطيل زر الحذف إذا كان هناك سطر واحد فقط
                } else {
                    deleteButtons.forEach(btn => {
                        btn.disabled = false;
                    });
                }
            }

            (function() {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>
    @endsection
</x-app-layout>
