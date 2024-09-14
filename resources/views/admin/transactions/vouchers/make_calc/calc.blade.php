<x-app-layout>
    @section('VendorsCss')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.transactions') }} / </span>
            {{ __('admin.calc') }}
        </h4>


        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.account.calculate') }}" method="POST">
                        @csrf
                        <div class="form-group my-4">
                            <label for="">أدخل عدد الادخالات للقيام بالعملية الحسابية</label>
                            <input type="number" id="numInputs" name="numInputs" class="form-control" min="2"
                                max="10" value="0" onchange="updateInputs()" required>
                        </div>

                        <div id="inputFields">
                            <!-- Inputs will be added here dynamically -->
                        </div>

                        <button type="submit" class="btn btn-primary">Calculate</button>
                    </form>
                </div>

                @if (isset($result))
                    <div class="card-footer">
                        <h2 class="text-success">Result: {{ $result }}</h2>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @section('VendorsJS')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
        <script>
            function updateInputs() {
                const numberOfInputs = document.getElementById('numInputs').value;
                const inputFieldsContainer = document.getElementById('inputFields');

                inputFieldsContainer.innerHTML = '';

                for (let i = 1; i <= numberOfInputs; i++) {
                    const inputGroup = document.createElement('div');
                    inputGroup.classList.add('input-group', 'mb-3');
                    inputGroup.innerHTML = `<br>
                        <h5 for="numInputs">{{ __('admin.account_name') }}</h5> <br>
                        <select name="accounts[]" class="js-example-basic-single form-control" id="Number${i}">
                            <option value="">{{ __('admin.please_select') }}</option>
                            @foreach ($accounts_tree as $account)
                                <option value="{{ $account->account_code }}">{{ $account->account_name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <select name="operations[]" class="form-control">
                                <option value="+">+</option>
                                <option value="-">-</option>
                                <option value="*">*</option>
                                <option value="/">/</option>
                            </select>
                        </div>
                    `;
                    inputFieldsContainer.appendChild(inputGroup);
                }

                // Reinitialize Select2 for the new elements
                $('.js-example-basic-single').select2();
            }

            $(document).ready(function() {
                // Initialize Select2 for any existing elements
                $('.js-example-basic-single').select2();
            });
        </script>

    @endsection
</x-app-layout>
