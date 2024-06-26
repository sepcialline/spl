<x-app-layout>
    @section('title')
        {{ __('admin.accounts_chart_of_accounts') }}
    @endsection
    @section('VendorsCss')
        <style>
            ul,
            #myUL {
                list-style-type: none;
            }

            #myUL {
                margin: 0;
                padding: 0;
            }

            .caret {
                cursor: pointer;
                -webkit-user-select: none;
                /* Safari 3.1+ */
                -moz-user-select: none;
                /* Firefox 2+ */
                -ms-user-select: none;
                /* IE 10+ */
                user-select: none;
            }

            .caret::before {
                content: "\25B6";
                color: black;
                display: inline-block;
                margin-right: 6px;
            }

            .caret-down::before {
                -ms-transform: rotate(90deg);
                /* IE 9 */
                -webkit-transform: rotate(90deg);
                /* Safari */
                '
     transform: rotate(90deg);
            }

            .nested {
                display: none;
            }

            .active {
                display: block;
            }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection


    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="fw-light text-muted">{{ __('admin.accounts_chart_of_accounts') }} /</span>
            {{ __('admin.accounts_accounts_chart_of_accounts_list') }}
        </h4>


        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <ul id="myUL">
                            @foreach ($accounts as $account)
                                <li><span class="caret">{{ $account->account_name }}</span>
                                    <span style="cursor: pointer;" onclick="editFunctipon({{ $account->id }})"><i
                                            class='bx bxs-pencil'></i></span>
                                    <ul class="nested">
                                        @foreach ($account->childrenAccounts as $childAccount)
                                            @include('admin.account.includes.child', [
                                                'child_account' => $childAccount,
                                            ])
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.account.store') }}" method="post"
                            class="row g-3 needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="id" id="id" value="">

                            <div class="mb-1">
                                <label for="defaultSelect" class="form-label">{{ __('admin.level') }}</label>
                                <select id="level" class="form-select js-example-basic-single" name="level"
                                    required>
                                    {{-- <option value="">{{ __('admin.please_select') }}</option> --}}
                                    @for ($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="defaultSelect" class="form-label">{{ __('admin.parent_account') }}</label>
                                <select id="parent" class="form-select js-example-basic-single" name="parent">

                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="defaultSelect"
                                    class="form-label">{{ __('admin.accounts_arabic_name') }}</label>
                                <input type="text" id="name_ar" class="form-control" name="name_ar" required>
                            </div>
                            <div class="mb-1">
                                <label for="defaultSelect"
                                    class="form-label">{{ __('admin.accounts_english_name') }}</label>
                                <input type="text" id="name_en" class="form-control" name="name_en" required>
                            </div>
                            <div class="mb-1">
                                <label for="defaultSelect" class="form-label">{{ __('admin.accounts_code') }}</label>
                                <input type="text" id="account_code"
                                    class="form-control @error('code') is-invalid @enderror" name="code" required>
                                @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <label for="account_type" class="form-label">{{ __('admin.type') }}</label>
                                <select id="account_type" class="form-select js-example-basic-single" name="type"
                                    required>
                                    {{-- <option  selected disabled>{{ __('admin.please_select') }}</option> --}}
                                    <option value="0">{{ __('admin.main_account') }}</option>
                                    <option value="1">{{ __('admin.secondary_account') }}</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="defaultSelect"
                                    class="form-label">{{ __('admin.nature_of_account') }}</label>
                                <select id="account_dc_type" class="form-select js-example-basic-single" required
                                    name="account_dc_type">
                                    {{-- <option  selected disabled>{{ __('admin.please_select') }}</option> --}}
                                    <option value="0">{{ __('admin.credit') }}</option>
                                    <option value="1">{{ __('admin.debit') }}</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="defaultSelect" class="form-label">{{ __('admin.account_final') }}</label>
                                <select id="account_final" class="form-select js-example-basic-single" required
                                    name="account_final">
                                    {{-- <option selected disabled>{{ __('admin.please_select') }}</option> --}}
                                    <option value="1">{{ __('admin.budget') }}</option>
                                    <option value="2">{{ __('admin.profits_and_losses') }}</option>
                                    <option value="3">{{ __('admin.trading') }}</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <button type="submit" class="btn btn-label-facebook">{{ __('admin.submit') }}</button>
                                <a id="empty" class="btn btn-label-danger">{{ __('admin.refresh') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>






        @section('VendorsJS')
            <script>
                var toggler = document.getElementsByClassName("caret");
                var i;

                for (i = 0; i < toggler.length; i++) {
                    toggler[i].addEventListener("click", function() {
                        this.parentElement.querySelector(".nested").classList.toggle("active");
                        this.classList.toggle("caret-down");
                    });
                }
            </script>

            <script>
                $(document).on('change', '#level', function() {
                    var locale = document.getElementsByTagName("html")[0].getAttribute("lang");
                    var level = $(this).val();
                    var lang = "{{ App::getLocale() }}"
                    $.ajax({
                        method: 'GET',
                        url: "{{ route('admin.account.get_parent') }}",
                        data: {
                            level: level
                        },
                        success: function(res) {
                            $('#parent').empty();
                            $.each(res, function(key, value) {

                                if (lang == "en") {
                                    $('#parent').append("<option value=" + value.id + ">" + value
                                        .account_name.en + "</option>")
                                } else {
                                    $('#parent').append("<option value=" + value.id + ">" + value
                                        .account_name.ar + "</option>")
                                }
                            })
                        }
                    })
                });
            </script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.js-example-basic-single').select2();
                });
            </script>
            <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (function() {
                    'use strict'

                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.querySelectorAll('.needs-validation')

                    // Loop over them and prevent submission
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

            <script>
                function editFunctipon(id) {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('admin.account.edit') }}",
                        data: {
                            id: id
                        },
                        success: function(res) {

                            $("#level option[value=" + res.account_level + "]").attr('selected', false).change();
                            $("#parent option[value=" + res.account_parent + "]").attr('selected', false).change();
                            $("#account_type option[value=" + res.account_type + "]").attr('selected', false).change();
                            $("#account_dc_type option[value=" + res.account_dc_type + "]").attr('selected', false)
                                .change();
                            $("#account_final option[value=" + res.account_final + "]").attr('selected', false)
                        .change();

                            console.log('res :>> ', res);
                            $('#id').val(res.id);
                            $("#level option[value=" + res.account_level + "]").attr('selected', true).change();
                            $("#parent option[value=" + res.account_parent + "]").attr('selected', true).change();

                            $('#name_ar').val(res.account_name.ar)
                            $('#name_en').val(res.account_name.en)
                            $('#account_code').val(res.account_code)
                            $("#account_type option[value=" + res.account_type + "]").attr('selected', true).change();
                            $("#account_dc_type option[value=" + res.account_dc_type + "]").attr('selected', true)
                                .change();
                            $("#account_final option[value=" + res.account_final + "]").attr('selected', true).change();


                        }
                    })
                }
            </script>

            <script>
                $('#empty').on('click', function() {
                    $('#id').val('')
                    $('#name_ar').val('')
                    $('#name_en').val('')
                    $('#account_code').val('')
                });
            </script>
        @endsection
</x-app-layout>
