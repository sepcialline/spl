<x-vendor-layout>
    @section('title')
        {{ __('admin.dashboard_dashboard') }}
    @endsection

    @section('VendorsCss')
        <!-- Page CSS -->
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/css/pages/page-profile.css') }}" />
        <!-- Additional CSS -->
        <style>
            .service-card {
                cursor: pointer !important;
                border: 2px solid transparent !important;
                ;
                transition: border-color 0.3s ease, background-color 0.3s ease !important;
                ;
                padding: 15px !important;
                border-radius: 10px !important;
                ;
                margin-bottom: 10px !important;
                ;
                text-align: center !important;
                ;
                background-color: #fff !important;
                ;
                /* Ensure background is white */
            }

            .service-card input[type="checkbox"] {
                display: none !important;
            }

            .service-card.active {
                border-color: #007bff !important;
                ;
                background-color: rgba(0, 123, 255, 0.1) !important;
                ;
            }

            .service-card h5 {
                margin: 0 !important;
                font-size: 18px !important;
                font-weight: bold !important;
                ;
            }
        </style>
    @endsection

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('vendor.services.store') }}" method="post">
                                    <input type="hidden" name="company_id" value="{{$company_id}}">
                                    @csrf
                                    <div class="row">
                                        @foreach ($services as $service)
                                            <div class="col-md-3 m-2 p-2">
                                                <div class="card" style="background-image: url('{{asset('build/assets/img/pages/profile-banner.png')}}')">
                                                    <label class="" for="service-{{ $service->id }}">
                                                        <div class="card-body">
                                                            <input type="checkbox" name="services[]"
                                                                value="{{ $service->id }}"
                                                                id="service-{{ $service->id }}">
                                                            <h5>{{ $service->name }}</h5>
                                                        </div>
                                                    </label>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('VendorsJs')
        <script>
            document.querySelectorAll('.service-card').forEach(function(card) {
                card.addEventListener('click', function() {
                    alert(checkbox.checked)
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    this.classList.toggle('active', checkbox.checked);
                });
            });
        </script>
    @endsection
</x-vendor-layout>
