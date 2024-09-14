<x-app-layout>
    @section('title')
        {{ __('admin.transactions') }} | {{ __('admin.journal_voucher') }}
    @endsection

    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
        <style>
            .readonly {
                background: #eee;
                /* لون الخلفية الرمادي */
            }

            .alert-message {
                color: red;
                font-weight: bold;
            }

            .add-row-btn {
                margin-top: 10px;
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
                @if (session('error'))
                    <div class="alert-message">{{ session('error') }}</div>
                @endif

                <div class="row my-4">
                    <div class="col-md-3">
                        <div class="d-flex justify-content-end">
                            <input type="hidden" class="form-control" name="number" value="{{ $number }}">

                            <a class="btn btn-label-facebook"
                                href="{{ route('admin.account.edit_journal_voucher', $number - 1) }}">
                                <i class="bx bxs-direction-right"></i>
                            </a>

                            <input type="text" disabled class="form-control" value="{{ $number }}">

                            <a class="btn btn-label-facebook"
                                href="{{ route('admin.account.edit_journal_voucher', $number + 1) }}">
                                <i class="bx bxs-direction-left"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <form id="searchForm" action="{{ route('admin.account.edit_journal_voucher', ':number') }}"
                            method="get">
                            <input type="text" id="searchNumber" class="form-control" name="search_number"
                                placeholder="{{ __('admin.number_voucher') }}">
                            <button type="submit" class="btn btn-primary btn-sm d-none">
                        </form>
                    </div>
                    <div class="col">
                        @php
                        // Get the current full URL
                        $fullUrl = request()->url();

                        // Extract the number from the URL using a regular expression
                        preg_match('/edit_journal_voucher\/(\d+)/', $fullUrl, $matches);

                        // The number will be in $matches[1] if found
                        $number = $matches[1] ?? null;
                    @endphp

                    @if ($number)
                        <a href="{{ route('admin.account.print_journal_voucher', $number) }}" class="btn btn-outline-success"><i
                                class="bx bx-printer"></i></a>
                                @include('admin.transactions.vouchers.include.delete_form',['number'=>$number,'type'=> 1])
                    @else
                        <p>Number not found in the URL.</p>
                    @endif
                    </div>


                </div>

                <form action="{{ route('admin.account.update_journal_voucher') }}" method="post"
                    class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="row mt-2">
                        <div class="form-group col-4">
                            <label for="exampleFormControlInput1">{{ __('admin.date') }}</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ Carbon\Carbon::parse($journals[0]->transaction_date)->format('Y-m-d') }}">
                        </div>
                        <div class="form-group col">
                            <label for="exampleFormControlInput1">{{ __('admin.statment') }}</label>
                            <textarea name="statment_for_journal" class="form-control" id="" cols="" rows="1" required>{{ $journals[0]->statment_for_journal }}</textarea>
                        </div>

                    </div>

                    <table class="table table-bordered" id="entries-table">
                        <thead>
                            <tr>
                                <th width="15%">{{ __('admin.account_name') }}</th>
                                <th width="15%">{{ __('admin.credit') }}</th>
                                <th width="15%">{{ __('admin.debit') }}</th>
                                <th width="15%">{{ __('admin.cost_center') }}</th>
                                <th width="15%">{{ __('admin.statment') }}</th>
                                <th width="15%">{{ __('admin.branch_branch_name') }}</th>
                                <th width="5%">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <!-- Add two initial rows here -->
                            <input type="hidden" value="{{ $journals[0]->number }}" name="number">
                            @foreach ($journals as $key => $journal)
                                <input type="hidden" name="entry_id[]" value="{{ $journal->id }}">
                                <tr class="entry-row">
                                    <td class="p-0">
                                        <select name="account_id[]" class="js-example-basic-single" required>
                                            <option value="" selected disabled>{{ __('admin.please_select') }}
                                            </option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}"
                                                    @if ($account->account_code == $journal->debit_account_number) selected

                                                    @elseif($account->account_code == $journal->credit_account_number)
                                                    selected
                                                    @else @endif>
                                                    {{ $account->account_name }} | {{ $account->account_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" name="credit[]" value="{{ $journal?->amount_credit }}"
                                            class="form-control credit">
                                    </td>
                                    <td class="p-0">
                                        <input type="text" name="debit[]" value="{{ $journal?->amount_debit }}"
                                            class="form-control debit">
                                    </td>
                                    <td>
                                        <select name="cost_center[]" id="" class="js-example-basic-single">
                                            <option value="" selected>{{ __('admin.please_select') }}
                                            </option>
                                            @foreach ($cars as $car)
                                                <option value="{{ $car->id }}"
                                                    {{ $car->id == $journal->cost_center ? 'selected' : '' }}>
                                                    {{ $car->car_name }} |
                                                    {{ $car->car_plate }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <textarea name="statment[]" class="form-control" id="" cols="" rows="1" required>{{ $journal->statment }}</textarea>
                                    </td>
                                    <td>
                                        <select name="branch_id[]" id="" class="js-example-basic-single">
                                            <option value="" selected>{{ __('admin.please_select') }}
                                            </option>
                                            @foreach ($branchs as $branh)
                                                <option value="{{ $branh->id }}"
                                                    {{ $branh->id == $journal->branch_id ? 'selected' : '' }}>
                                                    {{ $branh->branch_name }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-0 text-center">
                                        <button type="button" class="btn btn-danger btn-sm delete-row-btn">-</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
  <!-- Total and Difference row -->
  <div class="row">
    <div class="col-12">
        <table class="table table-active ">
            <thead>
                <tr>
                    <th class="text-center">{{ __('admin.credit') }}</th>
                    <th class="text-center">{{ __('admin.debit') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" id="total-credit">0.00</td>
                    <td class="text-center" id="total-debit">0.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
                    <div class="my-2">
                        <button type="button" class="btn btn-label-info add-row-btn" id="add-row-btn">اضافة
                            سطر</button>
                        {{-- <button type="submit" class="btn btn-label-secondary save-btn" name="save_type"
                            value="save_print">{{ __('admin.save_and_print') }}</button> --}}
                        <button type="submit" class="btn btn-label-secondary save-btn" name="save_type"
                            value="save">{{ __('admin.just_save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('VendorsJS')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                // Initialize select2 for existing selects
                function initializeSelect2() {
                    $(".js-example-basic-single").select2();
                }

                initializeSelect2();

                // Function to handle adding new rows
                $('#add-row-btn').on('click', function() {
                    const tableBody = $('#table-body');

                    // Create a new row
                    const newRow = `
                        <tr class="entry-row">
                            <td class="p-0">
                                <select name="account_id[]" class="js-example-basic-single" required>
                                    <option value="" selected disabled>{{ __('admin.please_select') }}</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->account_name }} | {{ $account->account_code }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="text" name="credit[]" class="form-control credit">
                            </td>
                            <td class="p-0">
                                <input type="text" name="debit[]" class="form-control debit">
                            </td>
                            <td>
                                <select name="cost_center[]" id="" class="js-example-basic-single">
                                        <option value="" selected>{{ __('admin.please_select') }}</option>
                                        @foreach ($cars as $car)
                                            <option value="{{ $car->id }}">{{ $car->car_name }} | {{ $car->car_plate }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <textarea name="statment[]" class="form-control" id="" cols="" rows="1" required></textarea>
                                </td>
                                <td>
                                    <select name="branch_id[]" id="" class="js-example-basic-single">
                                        <option value="" selected>{{ __('admin.please_select') }}</option>
                                        @foreach ($branchs as $branh)
                                            <option value="{{ $branh->id }}">{{ $branh->branch_name }} </option>
                                        @endforeach
                                    </select>
                                </td>
                            <td class="p-0 text-center">
                                <button type="button" class="btn btn-danger btn-sm delete-row-btn">-</button>
                            </td>
                        </tr>
                    `;

                    // Append the new row to the table body
                    tableBody.append(newRow);

                    // Reinitialize select2 for the new row
                    initializeSelect2();
                });

                // Function to handle row deletion
                $('#table-body').on('click', '.delete-row-btn', function() {
                    $(this).closest('tr').remove();
                    checkBalance(); // Recalculate the balance after a row is deleted
                });

                // Function to toggle input fields based on balance
                function toggleInput(input, otherInput) {
                    if (input.value) {
                        otherInput.setAttribute('readonly', true);
                        otherInput.classList.add('readonly');
                    } else {
                        otherInput.removeAttribute('readonly');
                        otherInput.classList.remove('readonly');
                    }
                }

                function checkBalance() {
                    let totalCredit = 0;
                    let totalDebit = 0;

                    $('input.credit').each(function() {
                        totalCredit += parseFloat($(this).val()) || 0;
                    });

                    $('input.debit').each(function() {
                        totalDebit += parseFloat($(this).val()) || 0;
                    });

                    if (totalCredit === totalDebit && totalCredit > 0 && totalDebit > 0) {
                        $('.save-btn').removeAttr('disabled');
                    } else {
                        $('.save-btn').attr('disabled', true);
                    }
                }

                // Initialize event listeners for existing rows
                function initializeRow(row) {
                    const creditInput = row.find('input.credit');
                    const debitInput = row.find('input.debit');

                    creditInput.on('input', function() {
                        toggleInput(creditInput[0], debitInput[0]);
                        checkBalance();
                    });

                    debitInput.on('input', function() {
                        toggleInput(debitInput[0], creditInput[0]);
                        checkBalance();
                    });
                }

                $('tr.entry-row').each(function() {
                    initializeRow($(this));
                });

                // Add event listener for newly added rows
                $('#table-body').on('input', 'input.credit, input.debit', function() {
                    checkBalance();
                });

                // Disable form submission if there are invalid fields
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
            });
        </script>
        <script>
            document.getElementById('searchForm').addEventListener('submit', function(event) {
                event.preventDefault(); // منع الإرسال التلقائي للنموذج

                // الحصول على الرقم المدخل
                var number = document.getElementById('searchNumber').value;

                // تعديل الرابط في الفورم
                var formAction = this.action.replace(':number', number);

                // تعيين الرابط المعدل للنموذج
                this.action = formAction;

                // إرسال النموذج بعد التعديل
                this.submit();
            });
        </script>

<script>
    // Function to calculate totals and difference
    function updateTotalsAndDifference() {
        let totalCredit = 0;
        let totalDebit = 0;

        $('.credit').each(function() {
            const creditValue = parseFloat($(this).val()) || 0;
            totalCredit += creditValue;
        });

        $('.debit').each(function() {
            const debitValue = parseFloat($(this).val()) || 0;
            totalDebit += debitValue;
        });

        $('#total-credit').text(totalCredit.toFixed(2));
        $('#total-debit').text(totalDebit.toFixed(2));
        $('#balance-difference').text((totalDebit - totalCredit).toFixed(2));
    }

    // Update totals and difference on input change
    $(document).on('input', '.credit, .debit', function() {
        updateTotalsAndDifference();
    });

    // Trigger update on initial load
    updateTotalsAndDifference();
</script>
    @endsection
</x-app-layout>
