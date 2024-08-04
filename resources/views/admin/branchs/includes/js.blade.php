@section('VendorsJS')
<script>
    $(document).ready(function() {
        $(document).on('submit', 'form', function() {
            $('button').attr('disabled', 'disabled');
            $(".spinner-border").removeClass("d-none");
        });
    });
</script>
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
                            .account_name.en + '#'+ value.account_code   + "</option>")
                    } else {
                        $('#parent').append("<option value=" + value.id + ">" + value
                            .account_name.ar + '#'+ value.account_code   + "</option>")
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

{{-- <script>
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
</script> --}}

<script>
    $('#empty').on('click', function() {
        $('#id').val('')
        $('#name_ar').val('')
        $('#name_en').val('')
        $('#account_code').val('')
    });
</script>
@endsection
