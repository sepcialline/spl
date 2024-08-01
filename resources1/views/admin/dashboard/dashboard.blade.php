<x-app-layout>
    @section('title')
        Dashboard
    @endsection

    @section('VendorsCss')
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script>
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('b1f9f902bdb6bf282cdb', {
                cluster: 'ap2'
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function(data) {
                $("#live").load(window.location.href + " #live");
                console.log(JSON.stringify(data));

            });
        </script>
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-2">


            <!-- User Stats-->
            <h5 class="card-title mb-4 col-12">{{ __('admin.dashboard_user_stats') }}</h5>
            <div class="col-sm-3 col-12 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="mb-1">{{ $user_stats['admins'] }}</h2>
                        <span class="text-muted">{{ __('admin.dashboard_user_stats_admin') }}</span>
                        <div id="referralLineChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-12 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="mb-1">{{ $user_stats['users'] }}</h2>
                        <span class="text-muted">{{ __('admin.dashboard_user_stats_users') }}</span>
                        <div id="referralLineChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-12 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="mb-1">{{ $user_stats['riders'] }}</h2>
                        <span class="text-muted">{{ __('admin.dashboard_user_stats_riders') }}</span>
                        <div id="referralLineChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-12 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="mb-1">{{ $user_stats['companies'] }}</h2>
                        <span class="text-muted">{{ __('admin.dashboard_user_stats_companies') }}</span>
                        <div id="referralLineChart"></div>
                    </div>
                </div>
            </div>

            <!-- Shipmeint Stats-->
            {{-- <h5 class="card-title mb-4 col-12">{{ __('admin.dashboard_shipment_stats') }}</h5>
            <div class="row col-md-8">
                <div class="col-sm-4 col-12 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2 class="mb-1">{{ $user_stats['admins'] }}</h2>
                            <span class="text-muted">{{ __('admin.dashboard_shipment_stats_total') }}</span>
                            <div id="referralLineChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-12 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2 class="mb-1">{{ $user_stats['users'] }}</h2>
                            <span class="text-muted">{{ __('admin.dashboard_user_stats_users') }}</span>
                            <div id="referralLineChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-12 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2 class="mb-1">{{ $user_stats['riders'] }}</h2>
                            <span class="text-muted">{{ __('admin.dashboard_user_stats_riders') }}</span>
                            <div id="referralLineChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-12 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2 class="mb-1">{{ $user_stats['companies'] }}</h2>
                            <span class="text-muted">{{ __('admin.dashboard_user_stats_companies') }}</span>
                            <div id="referralLineChart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-sm-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div id="impressionDonutChart"></div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <img src="{{asset('build/assets/team.png')}}" class="img-fluid" alt="..."> --}}
        </div>
        <div class="card">
            <div class="card-header">
                <h3>{{ \Carbon\Carbon::now()->format('Y-m-d') }} Live مباشر</h3>
            </div>
            <div class="card-body" style="overflow: auto; height:650px">
                <div id="live">
                    @foreach ($trackings as $tracking)
                        <div class="alert alert-secondary" role="alert">
                            <h6 class="alert-heading">{{ $tracking->shipment->shipment_refrence ?? '' }} |
                                {{ $tracking->Company->name ?? '' }}| {{ $tracking->Rider->name ?? '' }}</h6>
                            <p> <strong
                                    class=" btn btn-sm {{ $tracking->status->html_code }}">{{ $tracking->status->name }}</strong>
                                | {{ $tracking->action ?? '' }}   | {{ $tracking->notes ?? '' }}</p>
                            <hr>
                            <p class="mb-0">{{ $tracking->created_at }}</p>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>


    </div>



    @section('VendorsJS')

    @endsection
</x-app-layout>
