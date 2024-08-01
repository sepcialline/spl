<x-guest-layout>
    @section('title')
        Login
    @endsection
    @section('css')
    @endsection

    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
                <div class="flex-row text-center mx-auto">
                    <img src="{{ asset('build/assets/img/login/login.svg') }}" alt="Auth Cover Bg color" width="520"
                        class="img-fluid authentication-cover-img"
                        data-app-light-img="{{ asset('build/assets/img/login/login.svg') }}"
                        data-app-dark-img="{{ asset('build/assets/img/login/login.svg') }}" />
                    <div class="mx-auto">
                        <h3>{{ __('admin.welcome') }}</h3>
                        <p> {{ __('admin.app_dic') }}</p>
                    </div>
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-4">
                        <a href="{{ route('vendor.login.form') }}" class="app-brand-link gap-2 mb-2">

                            <img width="100%"
                                src="{{ asset('build/assets/img/logo/logo_') }}{{ LaravelLocalization::getCurrentLocale() }}.png" />
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">{{ __('admin.slogin') }}</h4>


                    <form id="formAuthentication" class="mb-3" action="{{ route('vendor.check.login') }}"
                        method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('admin.login_mobile') }}</label>
                            <input type="text" class="form-control" id="email" name="mobile"
                                placeholder="{{ __('admin.login_mobile_place') }}" autofocus />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">{{ __('admin.login_password') }}</label>
                                <a href="{{ route('vendor.forget_password') }}">
                                    <small>{{ __('admin.login_forgot_password') }}</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                                <label class="form-check-label" for="remember-me"> {{ __('admin.login_remember_me') }}
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100">{{ __('admin.login_Sign_in') }}</button>
                    </form>


                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
    @section('js')
        <script src="{{ asset('build/assets/js/pages-auth_') }}{{ LaravelLocalization::getCurrentLocale() }}.js"></script>
    @endsection
</x-guest-layout>
