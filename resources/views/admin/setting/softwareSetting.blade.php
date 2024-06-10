<x-app-layout>
    @section('title')
        {{ __('admin.setting_software_setting') }}
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.setting_general_setting') }} / </span>
            {{ __('admin.setting_software_setting') }}
        </h4>



        <!-- Multi Column with Form Separator -->
        <div class="card mb-4">

            <form method="POST" action="{{ route('admin.update_settings') }}" enctype="multipart/form-data" class="card-body">
                @csrf
                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="avatar mb-3">
                            <img id="en_logo" src="{{ asset('build/assets/img/uploads/settings/'.$data->logo_en) }}"
                                alt="{{ __('admin.setting_english_logo') }}">
                        </div>
                        <label for="english_logo" class="form-label">{{ __('admin.setting_english_logo') }}</label>
                        <input class="form-control" name="english_logo" type="file" id="english_logo" onchange="document.getElementById('en_logo').src=window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="col-md-4">
                        <div class="avatar mb-3">
                            <img id="ar_logo" src="{{ asset('build/assets/img/uploads/settings/'.$data->logo_ar) }}"
                                alt="{{ __('admin.setting_arabic_logo') }}">
                        </div>
                        <label for="arabic_logo" class="form-label">{{ __('admin.setting_arabic_logo') }}</label>
                        <input class="form-control" name="arabic_logo" type="file" id="arabic_logo" onchange="document.getElementById('ar_logo').src=window.URL.createObjectURL(this.files[0])">
                    </div>

                    <div class="col-md-4">
                        <div class="avatar mb-3">
                            <img id="fav_logo" src="{{ asset('build/assets/img/uploads/settings/'.$data->favicon) }}"
                                alt="{{ __('admin.setting_favicon') }}">
                        </div>

                        <label for="favicon" class="form-label">{{ __('admin.setting_favicon') }}</label>
                        <input class="form-control" name="favicon" type="file" id="favicon" onchange="document.getElementById('fav_logo').src=window.URL.createObjectURL(this.files[0])">
                    </div>


                    <div class="col-md-6">
                        <label class="form-label"
                            for="english_company_name">{{ __('admin.setting_english_company_name') }}</label>
                        <input type="text" name="english_company_name"
                            value="{{ $data->getTranslation('name', 'en') }}" id="english_company_name"
                            class="form-control" placeholder="{{ __('admin.setting_english_company_name') }}" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"
                            for="arabic_company_name">{{ __('admin.setting_arabic_company_name') }}</label>
                        <input type="text" name="arabic_company_name"
                            value="{{ $data->getTranslation('name', 'ar') }}" id="arabic_company_name"
                            class="form-control" placeholder="{{ __('admin.setting_arabic_company_name') }}" />
                    </div>

                    {{-- setting_english_description --}}
                    <div class="col-md-12">
                        <label class="form-label"
                            for="english_description">{{ __('admin.setting_english_description') }}</label>
                        <input type="text" name="english_description"
                            value="{{ $data->getTranslation('description', 'en') }}" id="english_description"
                            class="form-control" placeholder="{{ __('admin.setting_english_description') }}" />
                    </div>
                    <div class="col-md-12">
                        <label class="form-label"
                            for="arabic_description">{{ __('admin.setting_arabic_description') }}</label>
                        <input type="text" name="arabic_description"
                            value="{{ $data->getTranslation('description', 'ar') }}" id="arabic_description"
                            class="form-control" placeholder="{{ __('admin.setting_arabic_description') }}" />
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="multicol-email">{{ __('admin.setting_email') }}</label>
                        <div class="input-group input-group-merge">
                            <input type="text" value="{{ $data->email }}" id="multicol-email" class="form-control"
                                placeholder="{{ __('admin.setting_email') }}"
                                aria-label="{{ __('admin.setting_email') }}" aria-describedby="multicol-email2" />
                            <span class="input-group-text" id="multicol-email2">@example.com</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="url-mask">{{ __('admin.setting_domian_url') }}</label>
                        <input type="text" value="{{ $data->url }}" id="url-mask" class="form-control url-mask"
                            placeholder="{{ __('admin.setting_domian_url') }}"
                            aria-label="{{ __('admin.setting_domian_url') }}" />
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="landline">{{ __('admin.setting_landline') }}</label>
                        <input type="text" id="landline" name="landline" value="{{ $data->landline }}"
                            class="form-control phone-mask" placeholder="{{ __('admin.setting_landline') }}"
                            aria-label="{{ __('admin.setting_landline') }}" />
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="mobile">{{ __('admin.setting_mobile') }}</label>
                        <input type="text" id="mobile" name="mobile" value="{{ $data->mobile }}"
                            class="form-control phone-mask" placeholder="{{ __('admin.setting_mobile') }}"
                            aria-label="{{ __('admin.setting_mobile') }}" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="tax">{{ __('admin.setting_tax') }}</label>
                        <input type="text" id="tax" name="tax" value="{{ $data->tax }}"
                            class="form-control phone-mask" placeholder="{{ __('admin.setting_tax') }}"
                            aria-label="{{ __('admin.setting_tax') }}" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"
                            for="emirates_post_license_no">{{ __('admin.setting_emirates_post_license_no') }}</label>
                        <input type="text" id="emirates_post_license_no" name="tax"
                            value="{{ $data->emirates_post_license_no }}" class="form-control "
                            placeholder="{{ __('admin.setting_emirates_post_license_no') }}"
                            aria-label="{{ __('admin.setting_emirates_post_license_no') }}" />
                    </div>


                    <div class="col-md-12">
                        <label class="form-label"
                            for="english_address">{{ __('admin.setting_english_address') }}</label>
                        <input type="text" name="english_address"
                            value="{{ $data->getTranslation('address', 'en') }}" id="english_address"
                            class="form-control" placeholder="{{ __('admin.setting_english_description') }}" />
                    </div>
                    <div class="col-md-12">
                        <label class="form-label"
                            for="arabic_address">{{ __('admin.setting_arabic_address') }}</label>
                        <input type="text" name="arabic_address"
                            value="{{ $data->getTranslation('address', 'ar') }}" id="arabic_address"
                            class="form-control" placeholder="{{ __('admin.setting_arabic_description') }}" />
                    </div>


                </div>



                <hr class="my-4 mx-n4" />

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="map_longitude">{{ __('admin.setting_map_longitude') }}</label>
                                <input type="text" id="map_longitude" class="form-control" name="map_longitude" value="{{ $data->map_longitude }}"
                                    placeholder="{{ __('admin.setting_map_longitude') }}" />
                                                </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="map_latitude">{{ __('admin.setting_map_latitude') }}</label>
                                <input type="text" id="map_latitude" class="form-control" name="map_latitude" value="{{ $data->map_latitude }}"
                                    placeholder="{{ __('admin.setting_map_latitude') }}" />
                            </div>

                        </div>

                        <div class="row g-3">
                            <div class="mb-3 col-md-6">
                                <label for="tax_include" class="form-label">{{ __('admin.setting_tax_include') }}</label>
                                    <select class="form-select" id="tax_include" aria-label="Default select example" value="{{ $data->tax_include }}">
                                        {{-- <option selected>Open this select menu</option> --}}
                                        <option value='1'>Yes</option>
                                        <option value='0'>No</option>
                                    </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tax_percentage">{{ __('admin.setting_tax') }}</label>
                                <input type="number" min=0 max=100 id="tax_percentage" class="form-control"  value="{{ $data->tax_percentage }}" name="tax_percentage" placeholder="{{ __('admin.setting_tax') }}" value="{{ $data->tax_percentage_id }}"/>
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="mb-3 col-md-6">
                                <label for="time_format" class="form-label">{{ __('admin.setting_time_format') }}</label>
                                    <select class="form-select" id="time_format" value="{{ $data->time_format }}" aria-label="Default select example">
                                        {{-- <option selected>Open this select menu</option> --}}
                                        <option value="12">12</option>
                                        <option value="24">24</option>
                                    </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="date_format" class="form-label">{{ __('admin.setting_date_format') }}</label>
                                    <select class="form-select" id="date_format" aria-label="Default select example" value="{{ $data->date_format }}">
                                        {{-- <option selected>Open this select menu</option> --}}
                                        <option value="y-m-d">y-m-d</option>
                                        <option value="y-m-d h:m:s">y-m-d h:m:s</option>
                                    </select>
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="mb-3 col-md-6">
                                <label for="default_language" class="form-label">{{ __('admin.setting_default_language') }}</label>
                                    <select class="form-select" id="default_language" name="default_language" value="{{ $data->default_language }}" aria-label="Default select example">
                                        {{-- <option selected>Open this select menu</option> --}}
                                        <option value="en"
                                            @if ($data->default_language == 'en')
                                                selected = "selected"
                                            @endif
                                        >English</option>
                                        <option value="ar"
                                            @if ($data->default_language == 'ar')
                                                selected = "selected"
                                            @endif
                                        >Arabic</option>
                                    </select>
                            </div>
                            {{-- {{env('CUSTOM_ENV_VAR')}} --}}
                            <div class="mb-3 col-md-6">
                                <label for="date_format" class="form-label">{{ __('admin.setting_timezone') }}</label>
                                <select class="form-select"  id="timezone" name="timezone" class="custom-select">
                                    {{-- <option value="Africa/Abidjan">Africa/Abidjan GMT+0:00</option>
                                    <option value="Africa/Accra">Africa/Accra GMT+0:00</option>
                                    <option value="Africa/Addis_Ababa">Africa/Addis_Ababa GMT+3:00</option>
                                    <option value="Africa/Algiers">Africa/Algiers GMT+1:00</option>
                                    <option value="Africa/Asmara">Africa/Asmara GMT+3:00</option>
                                    <option value="Africa/Asmera">Africa/Asmera GMT+3:00</option>
                                    <option value="Africa/Bamako">Africa/Bamako GMT+0:00</option>
                                    <option value="Africa/Bangui">Africa/Bangui GMT+1:00</option>
                                    <option value="Africa/Banjul">Africa/Banjul GMT+0:00</option>
                                    <option value="Africa/Bissau">Africa/Bissau GMT+0:00</option>
                                    <option value="Africa/Blantyre">Africa/Blantyre GMT+2:00</option>
                                    <option value="Africa/Brazzaville">Africa/Brazzaville GMT+1:00</option>
                                    <option value="Africa/Bujumbura">Africa/Bujumbura GMT+2:00</option>
                                    <option value="Africa/Cairo">Africa/Cairo GMT+2:00</option>
                                    <option value="Africa/Casablanca">Africa/Casablanca GMT+0:00</option>
                                    <option value="Africa/Ceuta">Africa/Ceuta GMT+1:00</option>
                                    <option value="Africa/Conakry">Africa/Conakry GMT+0:00</option>
                                    <option value="Africa/Dakar">Africa/Dakar GMT+0:00</option>
                                    <option value="Africa/Dar_es_Salaam">Africa/Dar_es_Salaam GMT+3:00</option>
                                    <option value="Africa/Djibouti">Africa/Djibouti GMT+3:00</option>
                                    <option value="Africa/Douala">Africa/Douala GMT+1:00</option>
                                    <option value="Africa/El_Aaiun">Africa/El_Aaiun GMT+0:00</option>
                                    <option value="Africa/Freetown">Africa/Freetown GMT+0:00</option>
                                    <option value="Africa/Gaborone">Africa/Gaborone GMT+2:00</option>
                                    <option value="Africa/Harare">Africa/Harare GMT+2:00</option>
                                    <option value="Africa/Johannesburg">Africa/Johannesburg GMT+2:00</option>
                                    <option value="Africa/Juba">Africa/Juba GMT+3:00</option>
                                    <option value="Africa/Kampala">Africa/Kampala GMT+3:00</option>
                                    <option value="Africa/Khartoum">Africa/Khartoum GMT+2:00</option>
                                    <option value="Africa/Kigali">Africa/Kigali GMT+2:00</option>
                                    <option value="Africa/Kinshasa">Africa/Kinshasa GMT+1:00</option>
                                    <option value="Africa/Lagos">Africa/Lagos GMT+1:00</option>
                                    <option value="Africa/Libreville">Africa/Libreville GMT+1:00</option>
                                    <option value="Africa/Lome">Africa/Lome GMT+0:00</option>
                                    <option value="Africa/Luanda">Africa/Luanda GMT+1:00</option>
                                    <option value="Africa/Lubumbashi">Africa/Lubumbashi GMT+2:00</option>
                                    <option value="Africa/Lusaka">Africa/Lusaka GMT+2:00</option>
                                    <option value="Africa/Malabo">Africa/Malabo GMT+1:00</option>
                                    <option value="Africa/Maputo">Africa/Maputo GMT+2:00</option>
                                    <option value="Africa/Maseru">Africa/Maseru GMT+2:00</option>
                                    <option value="Africa/Mbabane">Africa/Mbabane GMT+2:00</option>
                                    <option value="Africa/Mogadishu">Africa/Mogadishu GMT+3:00</option>
                                    <option value="Africa/Monrovia">Africa/Monrovia GMT+0:00</option>
                                    <option value="Africa/Nairobi">Africa/Nairobi GMT+3:00</option>
                                    <option value="Africa/Ndjamena">Africa/Ndjamena GMT+1:00</option>
                                    <option value="Africa/Niamey">Africa/Niamey GMT+1:00</option>
                                    <option value="Africa/Nouakchott">Africa/Nouakchott GMT+0:00</option>
                                    <option value="Africa/Ouagadougou">Africa/Ouagadougou GMT+0:00</option>
                                    <option value="Africa/Porto-Novo">Africa/Porto-Novo GMT+1:00</option>
                                    <option value="Africa/Sao_Tome">Africa/Sao_Tome GMT+0:00</option>
                                    <option value="Africa/Timbuktu">Africa/Timbuktu GMT+0:00</option>
                                    <option value="Africa/Tripoli">Africa/Tripoli GMT+2:00</option>
                                    <option value="Africa/Tunis">Africa/Tunis GMT+1:00</option>
                                    <option value="Africa/Windhoek">Africa/Windhoek GMT+2:00</option>
                                    <option value="America/Adak">America/Adak GMT-10:00</option>
                                    <option value="America/Anchorage">America/Anchorage GMT-9:00</option>
                                    <option value="America/Anguilla">America/Anguilla GMT-4:00</option>
                                    <option value="America/Antigua">America/Antigua GMT-4:00</option>
                                    <option value="America/Araguaina">America/Araguaina GMT-3:00</option>
                                    <option value="America/Argentina/Buenos_Aires">America/Argentina/Buenos_Aires GMT-3:00</option>
                                    <option value="America/Argentina/Catamarca">America/Argentina/Catamarca GMT-3:00</option>
                                    <option value="America/Argentina/ComodRivadavia">America/Argentina/ComodRivadavia GMT-3:00</option>
                                    <option value="America/Argentina/Cordoba">America/Argentina/Cordoba GMT-3:00</option>
                                    <option value="America/Argentina/Jujuy">America/Argentina/Jujuy GMT-3:00</option>
                                    <option value="America/Argentina/La_Rioja">America/Argentina/La_Rioja GMT-3:00</option>
                                    <option value="America/Argentina/Mendoza">America/Argentina/Mendoza GMT-3:00</option>
                                    <option value="America/Argentina/Rio_Gallegos">America/Argentina/Rio_Gallegos GMT-3:00</option>
                                    <option value="America/Argentina/Salta">America/Argentina/Salta GMT-3:00</option>
                                    <option value="America/Argentina/San_Juan">America/Argentina/San_Juan GMT-3:00</option>
                                    <option value="America/Argentina/San_Luis">America/Argentina/San_Luis GMT-3:00</option>
                                    <option value="America/Argentina/Tucuman">America/Argentina/Tucuman GMT-3:00</option>
                                    <option value="America/Argentina/Ushuaia">America/Argentina/Ushuaia GMT-3:00</option>
                                    <option value="America/Aruba">America/Aruba GMT-4:00</option>
                                    <option value="America/Asuncion">America/Asuncion GMT-4:00</option>
                                    <option value="America/Atikokan">America/Atikokan GMT-5:00</option>
                                    <option value="America/Atka">America/Atka GMT-10:00</option>
                                    <option value="America/Bahia">America/Bahia GMT-3:00</option>
                                    <option value="America/Bahia_Banderas">America/Bahia_Banderas GMT-6:00</option>
                                    <option value="America/Barbados">America/Barbados GMT-4:00</option>
                                    <option value="America/Belem">America/Belem GMT-3:00</option>
                                    <option value="America/Belize">America/Belize GMT-6:00</option>
                                    <option value="America/Blanc-Sablon">America/Blanc-Sablon GMT-4:00</option>
                                    <option value="America/Boa_Vista">America/Boa_Vista GMT-4:00</option>
                                    <option value="America/Bogota">America/Bogota GMT-5:00</option>
                                    <option value="America/Boise">America/Boise GMT-7:00</option>
                                    <option value="America/Buenos_Aires">America/Buenos_Aires GMT-3:00</option>
                                    <option value="America/Cambridge_Bay">America/Cambridge_Bay GMT-7:00</option>
                                    <option value="America/Campo_Grande">America/Campo_Grande GMT-4:00</option>
                                    <option value="America/Cancun">America/Cancun GMT-5:00</option>
                                    <option value="America/Caracas">America/Caracas GMT-4:00</option>
                                    <option value="America/Catamarca">America/Catamarca GMT-3:00</option>
                                    <option value="America/Cayenne">America/Cayenne GMT-3:00</option>
                                    <option value="America/Cayman">America/Cayman GMT-5:00</option>
                                    <option value="America/Chicago">America/Chicago GMT-6:00</option>
                                    <option value="America/Chihuahua">America/Chihuahua GMT-7:00</option>
                                    <option value="America/Coral_Harbour">America/Coral_Harbour GMT-5:00</option>
                                    <option value="America/Cordoba">America/Cordoba GMT-3:00</option>
                                    <option value="America/Costa_Rica">America/Costa_Rica GMT-6:00</option>
                                    <option value="America/Creston">America/Creston GMT-7:00</option>
                                    <option value="America/Cuiaba">America/Cuiaba GMT-4:00</option>
                                    <option value="America/Curacao">America/Curacao GMT-4:00</option>
                                    <option value="America/Danmarkshavn">America/Danmarkshavn GMT+0:00</option>
                                    <option value="America/Dawson">America/Dawson GMT-8:00</option>
                                    <option value="America/Dawson_Creek">America/Dawson_Creek GMT-7:00</option>
                                    <option value="America/Denver">America/Denver GMT-7:00</option>
                                    <option value="America/Detroit">America/Detroit GMT-5:00</option>
                                    <option value="America/Dominica">America/Dominica GMT-4:00</option>
                                    <option value="America/Edmonton">America/Edmonton GMT-7:00</option>
                                    <option value="America/Eirunepe">America/Eirunepe GMT-5:00</option>
                                    <option value="America/El_Salvador">America/El_Salvador GMT-6:00</option>
                                    <option value="America/Ensenada">America/Ensenada GMT-8:00</option>
                                    <option value="America/Fort_Nelson">America/Fort_Nelson GMT-7:00</option>
                                    <option value="America/Fort_Wayne">America/Fort_Wayne GMT-5:00</option>
                                    <option value="America/Fortaleza">America/Fortaleza GMT-3:00</option>
                                    <option value="America/Glace_Bay">America/Glace_Bay GMT-4:00</option>
                                    <option value="America/Godthab">America/Godthab GMT-3:00</option>
                                    <option value="America/Goose_Bay">America/Goose_Bay GMT-4:00</option>
                                    <option value="America/Grand_Turk">America/Grand_Turk GMT-5:00</option>
                                    <option value="America/Grenada">America/Grenada GMT-4:00</option>
                                    <option value="America/Guadeloupe">America/Guadeloupe GMT-4:00</option>
                                    <option value="America/Guatemala">America/Guatemala GMT-6:00</option>
                                    <option value="America/Guayaquil">America/Guayaquil GMT-5:00</option>
                                    <option value="America/Guyana">America/Guyana GMT-4:00</option>
                                    <option value="America/Halifax">America/Halifax GMT-4:00</option>
                                    <option value="America/Havana">America/Havana GMT-5:00</option>
                                    <option value="America/Hermosillo">America/Hermosillo GMT-7:00</option>
                                    <option value="America/Indiana/Indianapolis">America/Indiana/Indianapolis GMT-5:00</option>
                                    <option value="America/Indiana/Knox">America/Indiana/Knox GMT-6:00</option>
                                    <option value="America/Indiana/Marengo">America/Indiana/Marengo GMT-5:00</option>
                                    <option value="America/Indiana/Petersburg">America/Indiana/Petersburg GMT-5:00</option>
                                    <option value="America/Indiana/Tell_City">America/Indiana/Tell_City GMT-6:00</option>
                                    <option value="America/Indiana/Vevay">America/Indiana/Vevay GMT-5:00</option>
                                    <option value="America/Indiana/Vincennes">America/Indiana/Vincennes GMT-5:00</option>
                                    <option value="America/Indiana/Winamac">America/Indiana/Winamac GMT-5:00</option>
                                    <option value="America/Indianapolis">America/Indianapolis GMT-5:00</option>
                                    <option value="America/Inuvik">America/Inuvik GMT-7:00</option>
                                    <option value="America/Iqaluit">America/Iqaluit GMT-5:00</option>
                                    <option value="America/Jamaica">America/Jamaica GMT-5:00</option>
                                    <option value="America/Jujuy">America/Jujuy GMT-3:00</option>
                                    <option value="America/Juneau">America/Juneau GMT-9:00</option>
                                    <option value="America/Kentucky/Louisville">America/Kentucky/Louisville GMT-5:00</option>
                                    <option value="America/Kentucky/Monticello">America/Kentucky/Monticello GMT-5:00</option>
                                    <option value="America/Knox_IN">America/Knox_IN GMT-6:00</option>
                                    <option value="America/Kralendijk">America/Kralendijk GMT-4:00</option>
                                    <option value="America/La_Paz">America/La_Paz GMT-4:00</option>
                                    <option value="America/Lima">America/Lima GMT-5:00</option>
                                    <option value="America/Los_Angeles">America/Los_Angeles GMT-8:00</option>
                                    <option value="America/Louisville">America/Louisville GMT-5:00</option>
                                    <option value="America/Lower_Princes">America/Lower_Princes GMT-4:00</option>
                                    <option value="America/Maceio">America/Maceio GMT-3:00</option>
                                    <option value="America/Managua">America/Managua GMT-6:00</option>
                                    <option value="America/Manaus">America/Manaus GMT-4:00</option>
                                    <option value="America/Marigot">America/Marigot GMT-4:00</option>
                                    <option value="America/Martinique">America/Martinique GMT-4:00</option>
                                    <option value="America/Matamoros">America/Matamoros GMT-6:00</option>
                                    <option value="America/Mazatlan">America/Mazatlan GMT-7:00</option>
                                    <option value="America/Mendoza">America/Mendoza GMT-3:00</option>
                                    <option value="America/Menominee">America/Menominee GMT-6:00</option>
                                    <option value="America/Merida">America/Merida GMT-6:00</option>
                                    <option value="America/Metlakatla">America/Metlakatla GMT-9:00</option>
                                    <option value="America/Mexico_City">America/Mexico_City GMT-6:00</option>
                                    <option value="America/Miquelon">America/Miquelon GMT-3:00</option>
                                    <option value="America/Moncton">America/Moncton GMT-4:00</option>
                                    <option value="America/Monterrey">America/Monterrey GMT-6:00</option>
                                    <option value="America/Montevideo">America/Montevideo GMT-3:00</option>
                                    <option value="America/Montreal">America/Montreal GMT-5:00</option>
                                    <option value="America/Montserrat">America/Montserrat GMT-4:00</option>
                                    <option value="America/Nassau">America/Nassau GMT-5:00</option>
                                    <option value="America/New_York">America/New_York GMT-5:00</option>
                                    <option value="America/Nipigon">America/Nipigon GMT-5:00</option>
                                    <option value="America/Nome">America/Nome GMT-9:00</option>
                                    <option value="America/Noronha">America/Noronha GMT-2:00</option>
                                    <option value="America/North_Dakota/Beulah">America/North_Dakota/Beulah GMT-6:00</option>
                                    <option value="America/North_Dakota/Center">America/North_Dakota/Center GMT-6:00</option>
                                    <option value="America/North_Dakota/New_Salem">America/North_Dakota/New_Salem GMT-6:00</option>
                                    <option value="America/Ojinaga">America/Ojinaga GMT-7:00</option>
                                    <option value="America/Panama">America/Panama GMT-5:00</option>
                                    <option value="America/Pangnirtung">America/Pangnirtung GMT-5:00</option>
                                    <option value="America/Paramaribo">America/Paramaribo GMT-3:00</option>
                                    <option value="America/Phoenix">America/Phoenix GMT-7:00</option>
                                    <option value="America/Port-au-Prince">America/Port-au-Prince GMT-5:00</option>
                                    <option value="America/Port_of_Spain">America/Port_of_Spain GMT-4:00</option>
                                    <option value="America/Porto_Acre">America/Porto_Acre GMT-5:00</option>
                                    <option value="America/Porto_Velho">America/Porto_Velho GMT-4:00</option>
                                    <option value="America/Puerto_Rico">America/Puerto_Rico GMT-4:00</option>
                                    <option value="America/Punta_Arenas">America/Punta_Arenas GMT-3:00</option>
                                    <option value="America/Rainy_River">America/Rainy_River GMT-6:00</option>
                                    <option value="America/Rankin_Inlet">America/Rankin_Inlet GMT-6:00</option>
                                    <option value="America/Recife">America/Recife GMT-3:00</option>
                                    <option value="America/Regina">America/Regina GMT-6:00</option>
                                    <option value="America/Resolute">America/Resolute GMT-6:00</option>
                                    <option value="America/Rio_Branco">America/Rio_Branco GMT-5:00</option>
                                    <option value="America/Rosario">America/Rosario GMT-3:00</option>
                                    <option value="America/Santa_Isabel">America/Santa_Isabel GMT-8:00</option>
                                    <option value="America/Santarem">America/Santarem GMT-3:00</option>
                                    <option value="America/Santiago">America/Santiago GMT-4:00</option>
                                    <option value="America/Santo_Domingo">America/Santo_Domingo GMT-4:00</option>
                                    <option value="America/Sao_Paulo">America/Sao_Paulo GMT-3:00</option>
                                    <option value="America/Scoresbysund">America/Scoresbysund GMT-1:00</option>
                                    <option value="America/Shiprock">America/Shiprock GMT-7:00</option>
                                    <option value="America/Sitka">America/Sitka GMT-9:00</option>
                                    <option value="America/St_Barthelemy">America/St_Barthelemy GMT-4:00</option>
                                    <option value="America/St_Johns">America/St_Johns GMT-4:30</option>
                                    <option value="America/St_Kitts">America/St_Kitts GMT-4:00</option>
                                    <option value="America/St_Lucia">America/St_Lucia GMT-4:00</option>
                                    <option value="America/St_Thomas">America/St_Thomas GMT-4:00</option>
                                    <option value="America/St_Vincent">America/St_Vincent GMT-4:00</option>
                                    <option value="America/Swift_Current">America/Swift_Current GMT-6:00</option>
                                    <option value="America/Tegucigalpa">America/Tegucigalpa GMT-6:00</option>
                                    <option value="America/Thule">America/Thule GMT-4:00</option>
                                    <option value="America/Thunder_Bay">America/Thunder_Bay GMT-5:00</option>
                                    <option value="America/Tijuana">America/Tijuana GMT-8:00</option>
                                    <option value="America/Toronto">America/Toronto GMT-5:00</option>
                                    <option value="America/Tortola">America/Tortola GMT-4:00</option>
                                    <option value="America/Vancouver">America/Vancouver GMT-8:00</option>
                                    <option value="America/Virgin">America/Virgin GMT-4:00</option>
                                    <option value="America/Whitehorse">America/Whitehorse GMT-8:00</option>
                                    <option value="America/Winnipeg">America/Winnipeg GMT-6:00</option>
                                    <option value="America/Yakutat">America/Yakutat GMT-9:00</option>
                                    <option value="America/Yellowknife">America/Yellowknife GMT-7:00</option>
                                    <option value="Antarctica/Casey">Antarctica/Casey GMT+8:00</option>
                                    <option value="Antarctica/Davis">Antarctica/Davis GMT+7:00</option>
                                    <option value="Antarctica/DumontDUrville">Antarctica/DumontDUrville GMT+10:00</option>
                                    <option value="Antarctica/Macquarie">Antarctica/Macquarie GMT+11:00</option>
                                    <option value="Antarctica/Mawson">Antarctica/Mawson GMT+5:00</option>
                                    <option value="Antarctica/McMurdo">Antarctica/McMurdo GMT+12:00</option>
                                    <option value="Antarctica/Palmer">Antarctica/Palmer GMT-3:00</option>
                                    <option value="Antarctica/Rothera">Antarctica/Rothera GMT-3:00</option>
                                    <option value="Antarctica/South_Pole">Antarctica/South_Pole GMT+12:00</option>
                                    <option value="Antarctica/Syowa">Antarctica/Syowa GMT+3:00</option>
                                    <option value="Antarctica/Troll">Antarctica/Troll GMT+0:00</option>
                                    <option value="Antarctica/Vostok">Antarctica/Vostok GMT+6:00</option>
                                    <option value="Arctic/Longyearbyen">Arctic/Longyearbyen GMT+1:00</option>
                                    <option value="Asia/Aden">Asia/Aden GMT+3:00</option>
                                    <option value="Asia/Almaty">Asia/Almaty GMT+6:00</option>
                                    <option value="Asia/Amman">Asia/Amman GMT+2:00</option>
                                    <option value="Asia/Anadyr">Asia/Anadyr GMT+12:00</option>
                                    <option value="Asia/Aqtau">Asia/Aqtau GMT+5:00</option>
                                    <option value="Asia/Aqtobe">Asia/Aqtobe GMT+5:00</option>
                                    <option value="Asia/Ashgabat">Asia/Ashgabat GMT+5:00</option>
                                    <option value="Asia/Ashkhabad">Asia/Ashkhabad GMT+5:00</option>
                                    <option value="Asia/Atyrau">Asia/Atyrau GMT+5:00</option>
                                    <option value="Asia/Baghdad">Asia/Baghdad GMT+3:00</option>
                                    <option value="Asia/Bahrain">Asia/Bahrain GMT+3:00</option>
                                    <option value="Asia/Baku">Asia/Baku GMT+4:00</option>
                                    <option value="Asia/Bangkok">Asia/Bangkok GMT+7:00</option>
                                    <option value="Asia/Barnaul">Asia/Barnaul GMT+7:00</option>
                                    <option value="Asia/Beirut">Asia/Beirut GMT+2:00</option>
                                    <option value="Asia/Bishkek">Asia/Bishkek GMT+6:00</option>
                                    <option value="Asia/Brunei">Asia/Brunei GMT+8:00</option>
                                    <option value="Asia/Calcutta">Asia/Calcutta GMT+5:30</option>
                                    <option value="Asia/Chita">Asia/Chita GMT+9:00</option>
                                    <option value="Asia/Choibalsan">Asia/Choibalsan GMT+8:00</option>
                                    <option value="Asia/Chongqing">Asia/Chongqing GMT+8:00</option>
                                    <option value="Asia/Chungking">Asia/Chungking GMT+8:00</option>
                                    <option value="Asia/Colombo">Asia/Colombo GMT+5:30</option>
                                    <option value="Asia/Dacca">Asia/Dacca GMT+6:00</option>
                                    <option value="Asia/Damascus">Asia/Damascus GMT+2:00</option>
                                    <option value="Asia/Dhaka">Asia/Dhaka GMT+6:00</option>
                                    <option value="Asia/Dili">Asia/Dili GMT+9:00</option>
                                    <option value="Asia/Dubai">Asia/Dubai GMT+4:00</option>
                                    <option value="Asia/Dushanbe">Asia/Dushanbe GMT+5:00</option>
                                    <option value="Asia/Famagusta">Asia/Famagusta GMT+2:00</option>
                                    <option value="Asia/Gaza">Asia/Gaza GMT+2:00</option>
                                    <option value="Asia/Harbin">Asia/Harbin GMT+8:00</option>
                                    <option value="Asia/Hebron">Asia/Hebron GMT+2:00</option>
                                    <option value="Asia/Ho_Chi_Minh">Asia/Ho_Chi_Minh GMT+7:00</option>
                                    <option value="Asia/Hong_Kong">Asia/Hong_Kong GMT+8:00</option>
                                    <option value="Asia/Hovd">Asia/Hovd GMT+7:00</option>
                                    <option value="Asia/Irkutsk">Asia/Irkutsk GMT+8:00</option>
                                    <option value="Asia/Istanbul">Asia/Istanbul GMT+3:00</option>
                                    <option value="Asia/Jakarta">Asia/Jakarta GMT+7:00</option>
                                    <option value="Asia/Jayapura">Asia/Jayapura GMT+9:00</option>
                                    <option value="Asia/Jerusalem">Asia/Jerusalem GMT+2:00</option>
                                    <option value="Asia/Kabul">Asia/Kabul GMT+4:30</option>
                                    <option value="Asia/Kamchatka">Asia/Kamchatka GMT+12:00</option>
                                    <option value="Asia/Karachi">Asia/Karachi GMT+5:00</option>
                                    <option value="Asia/Kashgar">Asia/Kashgar GMT+6:00</option>
                                    <option value="Asia/Kathmandu">Asia/Kathmandu GMT+5:45</option>
                                    <option value="Asia/Katmandu">Asia/Katmandu GMT+5:45</option>
                                    <option value="Asia/Khandyga">Asia/Khandyga GMT+9:00</option>
                                    <option value="Asia/Kolkata">Asia/Kolkata GMT+5:30</option>
                                    <option value="Asia/Krasnoyarsk">Asia/Krasnoyarsk GMT+7:00</option>
                                    <option value="Asia/Kuala_Lumpur">Asia/Kuala_Lumpur GMT+8:00</option>
                                    <option value="Asia/Kuching">Asia/Kuching GMT+8:00</option>
                                    <option value="Asia/Kuwait">Asia/Kuwait GMT+3:00</option>
                                    <option value="Asia/Macao">Asia/Macao GMT+8:00</option>
                                    <option value="Asia/Macau">Asia/Macau GMT+8:00</option>
                                    <option value="Asia/Magadan">Asia/Magadan GMT+11:00</option>
                                    <option value="Asia/Makassar">Asia/Makassar GMT+8:00</option>
                                    <option value="Asia/Manila">Asia/Manila GMT+8:00</option>
                                    <option value="Asia/Muscat">Asia/Muscat GMT+4:00</option>
                                    <option value="Asia/Nicosia">Asia/Nicosia GMT+2:00</option>
                                    <option value="Asia/Novokuznetsk">Asia/Novokuznetsk GMT+7:00</option>
                                    <option value="Asia/Novosibirsk">Asia/Novosibirsk GMT+7:00</option>
                                    <option value="Asia/Omsk">Asia/Omsk GMT+6:00</option>
                                    <option value="Asia/Oral">Asia/Oral GMT+5:00</option>
                                    <option value="Asia/Phnom_Penh">Asia/Phnom_Penh GMT+7:00</option>
                                    <option value="Asia/Pontianak">Asia/Pontianak GMT+7:00</option>
                                    <option value="Asia/Pyongyang">Asia/Pyongyang GMT+9:00</option>
                                    <option value="Asia/Qatar">Asia/Qatar GMT+3:00</option>
                                    <option value="Asia/Qostanay">Asia/Qostanay GMT+6:00</option>
                                    <option value="Asia/Qyzylorda">Asia/Qyzylorda GMT+5:00</option>
                                    <option value="Asia/Rangoon">Asia/Rangoon GMT+6:30</option>
                                    <option value="Asia/Riyadh">Asia/Riyadh GMT+3:00</option>
                                    <option value="Asia/Saigon">Asia/Saigon GMT+7:00</option>
                                    <option value="Asia/Sakhalin">Asia/Sakhalin GMT+11:00</option>
                                    <option value="Asia/Samarkand">Asia/Samarkand GMT+5:00</option>
                                    <option value="Asia/Seoul">Asia/Seoul GMT+9:00</option>
                                    <option value="Asia/Shanghai">Asia/Shanghai GMT+8:00</option>
                                    <option value="Asia/Singapore">Asia/Singapore GMT+8:00</option>
                                    <option value="Asia/Srednekolymsk">Asia/Srednekolymsk GMT+11:00</option>
                                    <option value="Asia/Taipei">Asia/Taipei GMT+8:00</option>
                                    <option value="Asia/Tashkent">Asia/Tashkent GMT+5:00</option>
                                    <option value="Asia/Tbilisi">Asia/Tbilisi GMT+4:00</option>
                                    <option value="Asia/Tehran">Asia/Tehran GMT+3:30</option>
                                    <option value="Asia/Tel_Aviv">Asia/Tel_Aviv GMT+2:00</option>
                                    <option value="Asia/Thimbu">Asia/Thimbu GMT+6:00</option>
                                    <option value="Asia/Thimphu">Asia/Thimphu GMT+6:00</option>
                                    <option value="Asia/Tokyo">Asia/Tokyo GMT+9:00</option>
                                    <option value="Asia/Tomsk">Asia/Tomsk GMT+7:00</option>
                                    <option value="Asia/Ujung_Pandang">Asia/Ujung_Pandang GMT+8:00</option>
                                    <option value="Asia/Ulaanbaatar">Asia/Ulaanbaatar GMT+8:00</option>
                                    <option value="Asia/Ulan_Bator">Asia/Ulan_Bator GMT+8:00</option>
                                    <option value="Asia/Urumqi">Asia/Urumqi GMT+6:00</option>
                                    <option value="Asia/Ust-Nera">Asia/Ust-Nera GMT+10:00</option>
                                    <option value="Asia/Vientiane">Asia/Vientiane GMT+7:00</option>
                                    <option value="Asia/Vladivostok">Asia/Vladivostok GMT+10:00</option>
                                    <option value="Asia/Yakutsk">Asia/Yakutsk GMT+9:00</option>
                                    <option value="Asia/Yangon">Asia/Yangon GMT+6:30</option>
                                    <option value="Asia/Yekaterinburg">Asia/Yekaterinburg GMT+5:00</option>
                                    <option value="Asia/Yerevan">Asia/Yerevan GMT+4:00</option>
                                    <option value="Atlantic/Azores">Atlantic/Azores GMT-1:00</option>
                                    <option value="Atlantic/Bermuda">Atlantic/Bermuda GMT-4:00</option>
                                    <option value="Atlantic/Canary">Atlantic/Canary GMT+0:00</option>
                                    <option value="Atlantic/Cape_Verde">Atlantic/Cape_Verde GMT-1:00</option>
                                    <option value="Atlantic/Faeroe">Atlantic/Faeroe GMT+0:00</option>
                                    <option value="Atlantic/Faroe">Atlantic/Faroe GMT+0:00</option>
                                    <option value="Atlantic/Jan_Mayen">Atlantic/Jan_Mayen GMT+1:00</option>
                                    <option value="Atlantic/Madeira">Atlantic/Madeira GMT+0:00</option>
                                    <option value="Atlantic/Reykjavik">Atlantic/Reykjavik GMT+0:00</option>
                                    <option value="Atlantic/South_Georgia">Atlantic/South_Georgia GMT-2:00</option>
                                    <option value="Atlantic/St_Helena">Atlantic/St_Helena GMT+0:00</option>
                                    <option value="Atlantic/Stanley">Atlantic/Stanley GMT-3:00</option>
                                    <option value="Australia/ACT">Australia/ACT GMT+10:00</option>
                                    <option value="Australia/Adelaide">Australia/Adelaide GMT+9:30</option>
                                    <option value="Australia/Brisbane">Australia/Brisbane GMT+10:00</option>
                                    <option value="Australia/Broken_Hill">Australia/Broken_Hill GMT+9:30</option>
                                    <option value="Australia/Canberra">Australia/Canberra GMT+10:00</option>
                                    <option value="Australia/Currie">Australia/Currie GMT+10:00</option>
                                    <option value="Australia/Darwin">Australia/Darwin GMT+9:30</option>
                                    <option value="Australia/Eucla">Australia/Eucla GMT+8:45</option>
                                    <option value="Australia/Hobart">Australia/Hobart GMT+10:00</option>
                                    <option value="Australia/LHI">Australia/LHI GMT+10:30</option>
                                    <option value="Australia/Lindeman">Australia/Lindeman GMT+10:00</option>
                                    <option value="Australia/Lord_Howe">Australia/Lord_Howe GMT+10:30</option>
                                    <option value="Australia/Melbourne">Australia/Melbourne GMT+10:00</option>
                                    <option value="Australia/NSW">Australia/NSW GMT+10:00</option>
                                    <option value="Australia/North">Australia/North GMT+9:30</option>
                                    <option value="Australia/Perth">Australia/Perth GMT+8:00</option>
                                    <option value="Australia/Queensland">Australia/Queensland GMT+10:00</option>
                                    <option value="Australia/South">Australia/South GMT+9:30</option>
                                    <option value="Australia/Sydney">Australia/Sydney GMT+10:00</option>
                                    <option value="Australia/Tasmania">Australia/Tasmania GMT+10:00</option>
                                    <option value="Australia/Victoria">Australia/Victoria GMT+10:00</option>
                                    <option value="Australia/West">Australia/West GMT+8:00</option>
                                    <option value="Australia/Yancowinna">Australia/Yancowinna GMT+9:30</option>
                                    <option value="Brazil/Acre">Brazil/Acre GMT-5:00</option>
                                    <option value="Brazil/DeNoronha">Brazil/DeNoronha GMT-2:00</option>
                                    <option value="Brazil/East">Brazil/East GMT-3:00</option>
                                    <option value="Brazil/West">Brazil/West GMT-4:00</option>
                                    <option value="CET">CET GMT+1:00</option>
                                    <option value="CST6CDT">CST6CDT GMT-6:00</option>
                                    <option value="Canada/Atlantic">Canada/Atlantic GMT-4:00</option>
                                    <option value="Canada/Central">Canada/Central GMT-6:00</option>
                                    <option value="Canada/Eastern">Canada/Eastern GMT-5:00</option>
                                    <option value="Canada/Mountain">Canada/Mountain GMT-7:00</option>
                                    <option value="Canada/Newfoundland">Canada/Newfoundland GMT-4:30</option>
                                    <option value="Canada/Pacific">Canada/Pacific GMT-8:00</option>
                                    <option value="Canada/Saskatchewan">Canada/Saskatchewan GMT-6:00</option>
                                    <option value="Canada/Yukon">Canada/Yukon GMT-8:00</option>
                                    <option value="Chile/Continental">Chile/Continental GMT-4:00</option>
                                    <option value="Chile/EasterIsland">Chile/EasterIsland GMT-6:00</option>
                                    <option value="Cuba">Cuba GMT-5:00</option>
                                    <option value="EET">EET GMT+2:00</option>
                                    <option value="EST5EDT">EST5EDT GMT-5:00</option>
                                    <option value="Egypt">Egypt GMT+2:00</option>
                                    <option value="Eire">Eire GMT+0:00</option>
                                    <option value="Etc/GMT">Etc/GMT GMT+0:00</option>
                                    <option value="Etc/GMT+0">Etc/GMT+0 GMT+0:00</option>
                                    <option value="Etc/GMT+1">Etc/GMT+1 GMT-1:00</option>
                                    <option value="Etc/GMT+10">Etc/GMT+10 GMT-10:00</option>
                                    <option value="Etc/GMT+11">Etc/GMT+11 GMT-11:00</option>
                                    <option value="Etc/GMT+12">Etc/GMT+12 GMT-12:00</option>
                                    <option value="Etc/GMT+2">Etc/GMT+2 GMT-2:00</option>
                                    <option value="Etc/GMT+3">Etc/GMT+3 GMT-3:00</option>
                                    <option value="Etc/GMT+4">Etc/GMT+4 GMT-4:00</option>
                                    <option value="Etc/GMT+5">Etc/GMT+5 GMT-5:00</option>
                                    <option value="Etc/GMT+6">Etc/GMT+6 GMT-6:00</option>
                                    <option value="Etc/GMT+7">Etc/GMT+7 GMT-7:00</option>
                                    <option value="Etc/GMT+8">Etc/GMT+8 GMT-8:00</option>
                                    <option value="Etc/GMT+9">Etc/GMT+9 GMT-9:00</option>
                                    <option value="Etc/GMT-0">Etc/GMT-0 GMT+0:00</option>
                                    <option value="Etc/GMT-1">Etc/GMT-1 GMT+1:00</option>
                                    <option value="Etc/GMT-10">Etc/GMT-10 GMT+10:00</option>
                                    <option value="Etc/GMT-11">Etc/GMT-11 GMT+11:00</option>
                                    <option value="Etc/GMT-12">Etc/GMT-12 GMT+12:00</option>
                                    <option value="Etc/GMT-13">Etc/GMT-13 GMT+13:00</option>
                                    <option value="Etc/GMT-14">Etc/GMT-14 GMT+14:00</option>
                                    <option value="Etc/GMT-2">Etc/GMT-2 GMT+2:00</option>
                                    <option value="Etc/GMT-3">Etc/GMT-3 GMT+3:00</option>
                                    <option value="Etc/GMT-4">Etc/GMT-4 GMT+4:00</option>
                                    <option value="Etc/GMT-5">Etc/GMT-5 GMT+5:00</option>
                                    <option value="Etc/GMT-6">Etc/GMT-6 GMT+6:00</option>
                                    <option value="Etc/GMT-7">Etc/GMT-7 GMT+7:00</option>
                                    <option value="Etc/GMT-8">Etc/GMT-8 GMT+8:00</option>
                                    <option value="Etc/GMT-9">Etc/GMT-9 GMT+9:00</option>
                                    <option value="Etc/GMT0">Etc/GMT0 GMT+0:00</option>
                                    <option value="Etc/Greenwich">Etc/Greenwich GMT+0:00</option>
                                    <option value="Etc/UCT">Etc/UCT GMT+0:00</option>
                                    <option value="Etc/UTC">Etc/UTC GMT+0:00</option>
                                    <option value="Etc/Universal">Etc/Universal GMT+0:00</option>
                                    <option value="Etc/Zulu">Etc/Zulu GMT+0:00</option>
                                    <option value="Europe/Amsterdam">Europe/Amsterdam GMT+1:00</option>
                                    <option value="Europe/Andorra">Europe/Andorra GMT+1:00</option>
                                    <option value="Europe/Astrakhan">Europe/Astrakhan GMT+4:00</option>
                                    <option value="Europe/Athens">Europe/Athens GMT+2:00</option>
                                    <option value="Europe/Belfast">Europe/Belfast GMT+0:00</option>
                                    <option value="Europe/Belgrade">Europe/Belgrade GMT+1:00</option>
                                    <option value="Europe/Berlin">Europe/Berlin GMT+1:00</option>
                                    <option value="Europe/Bratislava">Europe/Bratislava GMT+1:00</option>
                                    <option value="Europe/Brussels">Europe/Brussels GMT+1:00</option>
                                    <option value="Europe/Bucharest">Europe/Bucharest GMT+2:00</option>
                                    <option value="Europe/Budapest">Europe/Budapest GMT+1:00</option>
                                    <option value="Europe/Busingen">Europe/Busingen GMT+1:00</option>
                                    <option value="Europe/Chisinau">Europe/Chisinau GMT+2:00</option>
                                    <option value="Europe/Copenhagen">Europe/Copenhagen GMT+1:00</option>
                                    <option value="Europe/Dublin">Europe/Dublin GMT+0:00</option>
                                    <option value="Europe/Gibraltar">Europe/Gibraltar GMT+1:00</option>
                                    <option value="Europe/Guernsey">Europe/Guernsey GMT+0:00</option>
                                    <option value="Europe/Helsinki">Europe/Helsinki GMT+2:00</option>
                                    <option value="Europe/Isle_of_Man">Europe/Isle_of_Man GMT+0:00</option>
                                    <option value="Europe/Istanbul">Europe/Istanbul GMT+3:00</option>
                                    <option value="Europe/Jersey">Europe/Jersey GMT+0:00</option>
                                    <option value="Europe/Kaliningrad">Europe/Kaliningrad GMT+2:00</option>
                                    <option value="Europe/Kiev">Europe/Kiev GMT+2:00</option>
                                    <option value="Europe/Kirov">Europe/Kirov GMT+3:00</option>
                                    <option value="Europe/Lisbon">Europe/Lisbon GMT+0:00</option>
                                    <option value="Europe/Ljubljana">Europe/Ljubljana GMT+1:00</option>
                                    <option value="Europe/London">Europe/London GMT+0:00</option>
                                    <option value="Europe/Luxembourg">Europe/Luxembourg GMT+1:00</option>
                                    <option value="Europe/Madrid">Europe/Madrid GMT+1:00</option>
                                    <option value="Europe/Malta">Europe/Malta GMT+1:00</option>
                                    <option value="Europe/Mariehamn">Europe/Mariehamn GMT+2:00</option>
                                    <option value="Europe/Minsk">Europe/Minsk GMT+3:00</option>
                                    <option value="Europe/Monaco">Europe/Monaco GMT+1:00</option>
                                    <option value="Europe/Moscow">Europe/Moscow GMT+3:00</option>
                                    <option value="Europe/Nicosia">Europe/Nicosia GMT+2:00</option>
                                    <option value="Europe/Oslo">Europe/Oslo GMT+1:00</option>
                                    <option value="Europe/Paris">Europe/Paris GMT+1:00</option>
                                    <option value="Europe/Podgorica">Europe/Podgorica GMT+1:00</option>
                                    <option value="Europe/Prague">Europe/Prague GMT+1:00</option>
                                    <option value="Europe/Riga">Europe/Riga GMT+2:00</option>
                                    <option value="Europe/Rome">Europe/Rome GMT+1:00</option>
                                    <option value="Europe/Samara">Europe/Samara GMT+4:00</option>
                                    <option value="Europe/San_Marino">Europe/San_Marino GMT+1:00</option>
                                    <option value="Europe/Sarajevo">Europe/Sarajevo GMT+1:00</option>
                                    <option value="Europe/Saratov">Europe/Saratov GMT+4:00</option>
                                    <option value="Europe/Simferopol">Europe/Simferopol GMT+3:00</option>
                                    <option value="Europe/Skopje">Europe/Skopje GMT+1:00</option>
                                    <option value="Europe/Sofia">Europe/Sofia GMT+2:00</option>
                                    <option value="Europe/Stockholm">Europe/Stockholm GMT+1:00</option>
                                    <option value="Europe/Tallinn">Europe/Tallinn GMT+2:00</option>
                                    <option value="Europe/Tirane">Europe/Tirane GMT+1:00</option>
                                    <option value="Europe/Tiraspol">Europe/Tiraspol GMT+2:00</option>
                                    <option value="Europe/Ulyanovsk">Europe/Ulyanovsk GMT+4:00</option>
                                    <option value="Europe/Uzhgorod">Europe/Uzhgorod GMT+2:00</option>
                                    <option value="Europe/Vaduz">Europe/Vaduz GMT+1:00</option>
                                    <option value="Europe/Vatican">Europe/Vatican GMT+1:00</option>
                                    <option value="Europe/Vienna">Europe/Vienna GMT+1:00</option>
                                    <option value="Europe/Vilnius">Europe/Vilnius GMT+2:00</option>
                                    <option value="Europe/Volgograd">Europe/Volgograd GMT+4:00</option>
                                    <option value="Europe/Warsaw">Europe/Warsaw GMT+1:00</option>
                                    <option value="Europe/Zagreb">Europe/Zagreb GMT+1:00</option>
                                    <option value="Europe/Zaporozhye">Europe/Zaporozhye GMT+2:00</option>
                                    <option value="Europe/Zurich">Europe/Zurich GMT+1:00</option>
                                    <option value="GB">GB GMT+0:00</option>
                                    <option value="GB-Eire">GB-Eire GMT+0:00</option>
                                    <option value="GMT">GMT GMT+0:00</option>
                                    <option value="GMT0">GMT0 GMT+0:00</option>
                                    <option value="Greenwich">Greenwich GMT+0:00</option>
                                    <option value="Hongkong">Hongkong GMT+8:00</option>
                                    <option value="Iceland">Iceland GMT+0:00</option>
                                    <option value="Indian/Antananarivo">Indian/Antananarivo GMT+3:00</option>
                                    <option value="Indian/Chagos">Indian/Chagos GMT+6:00</option>
                                    <option value="Indian/Christmas">Indian/Christmas GMT+7:00</option>
                                    <option value="Indian/Cocos">Indian/Cocos GMT+6:30</option>
                                    <option value="Indian/Comoro">Indian/Comoro GMT+3:00</option>
                                    <option value="Indian/Kerguelen">Indian/Kerguelen GMT+5:00</option>
                                    <option value="Indian/Mahe">Indian/Mahe GMT+4:00</option>
                                    <option value="Indian/Maldives">Indian/Maldives GMT+5:00</option>
                                    <option value="Indian/Mauritius">Indian/Mauritius GMT+4:00</option>
                                    <option value="Indian/Mayotte">Indian/Mayotte GMT+3:00</option>
                                    <option value="Indian/Reunion">Indian/Reunion GMT+4:00</option>
                                    <option value="Iran">Iran GMT+3:30</option>
                                    <option value="Israel">Israel GMT+2:00</option>
                                    <option value="Jamaica">Jamaica GMT-5:00</option>
                                    <option value="Japan">Japan GMT+9:00</option>
                                    <option value="Kwajalein">Kwajalein GMT+12:00</option>
                                    <option value="Libya">Libya GMT+2:00</option>
                                    <option value="MET">MET GMT+1:00</option>
                                    <option value="MST7MDT">MST7MDT GMT-7:00</option>
                                    <option value="Mexico/BajaNorte">Mexico/BajaNorte GMT-8:00</option>
                                    <option value="Mexico/BajaSur">Mexico/BajaSur GMT-7:00</option>
                                    <option value="Mexico/General">Mexico/General GMT-6:00</option>
                                    <option value="NZ">NZ GMT+12:00</option>
                                    <option value="NZ-CHAT">NZ-CHAT GMT+12:45</option>
                                    <option value="Navajo">Navajo GMT-7:00</option>
                                    <option value="PRC">PRC GMT+8:00</option>
                                    <option value="PST8PDT">PST8PDT GMT-8:00</option>
                                    <option value="Pacific/Apia">Pacific/Apia GMT+13:00</option>
                                    <option value="Pacific/Auckland">Pacific/Auckland GMT+12:00</option>
                                    <option value="Pacific/Bougainville">Pacific/Bougainville GMT+11:00</option>
                                    <option value="Pacific/Chatham">Pacific/Chatham GMT+12:45</option>
                                    <option value="Pacific/Chuuk">Pacific/Chuuk GMT+10:00</option>
                                    <option value="Pacific/Easter">Pacific/Easter GMT-6:00</option>
                                    <option value="Pacific/Efate">Pacific/Efate GMT+11:00</option>
                                    <option value="Pacific/Enderbury">Pacific/Enderbury GMT+13:00</option>
                                    <option value="Pacific/Fakaofo">Pacific/Fakaofo GMT+13:00</option>
                                    <option value="Pacific/Fiji">Pacific/Fiji GMT+12:00</option>
                                    <option value="Pacific/Funafuti">Pacific/Funafuti GMT+12:00</option>
                                    <option value="Pacific/Galapagos">Pacific/Galapagos GMT-6:00</option>
                                    <option value="Pacific/Gambier">Pacific/Gambier GMT-9:00</option>
                                    <option value="Pacific/Guadalcanal">Pacific/Guadalcanal GMT+11:00</option>
                                    <option value="Pacific/Guam">Pacific/Guam GMT+10:00</option>
                                    <option value="Pacific/Honolulu">Pacific/Honolulu GMT-10:00</option>
                                    <option value="Pacific/Johnston">Pacific/Johnston GMT-10:00</option>
                                    <option value="Pacific/Kiritimati">Pacific/Kiritimati GMT+14:00</option>
                                    <option value="Pacific/Kosrae">Pacific/Kosrae GMT+11:00</option>
                                    <option value="Pacific/Kwajalein">Pacific/Kwajalein GMT+12:00</option>
                                    <option value="Pacific/Majuro">Pacific/Majuro GMT+12:00</option>
                                    <option value="Pacific/Marquesas">Pacific/Marquesas GMT-10:30</option>
                                    <option value="Pacific/Midway">Pacific/Midway GMT-11:00</option>
                                    <option value="Pacific/Nauru">Pacific/Nauru GMT+12:00</option>
                                    <option value="Pacific/Niue">Pacific/Niue GMT-11:00</option>
                                    <option value="Pacific/Norfolk">Pacific/Norfolk GMT+11:00</option>
                                    <option value="Pacific/Noumea">Pacific/Noumea GMT+11:00</option>
                                    <option value="Pacific/Pago_Pago">Pacific/Pago_Pago GMT-11:00</option>
                                    <option value="Pacific/Palau">Pacific/Palau GMT+9:00</option>
                                    <option value="Pacific/Pitcairn">Pacific/Pitcairn GMT-8:00</option>
                                    <option value="Pacific/Pohnpei">Pacific/Pohnpei GMT+11:00</option>
                                    <option value="Pacific/Ponape">Pacific/Ponape GMT+11:00</option>
                                    <option value="Pacific/Port_Moresby">Pacific/Port_Moresby GMT+10:00</option>
                                    <option value="Pacific/Rarotonga">Pacific/Rarotonga GMT-10:00</option>
                                    <option value="Pacific/Saipan">Pacific/Saipan GMT+10:00</option>
                                    <option value="Pacific/Samoa">Pacific/Samoa GMT-11:00</option>
                                    <option value="Pacific/Tahiti">Pacific/Tahiti GMT-10:00</option>
                                    <option value="Pacific/Tarawa">Pacific/Tarawa GMT+12:00</option>
                                    <option value="Pacific/Tongatapu">Pacific/Tongatapu GMT+13:00</option>
                                    <option value="Pacific/Truk">Pacific/Truk GMT+10:00</option>
                                    <option value="Pacific/Wake">Pacific/Wake GMT+12:00</option>
                                    <option value="Pacific/Wallis">Pacific/Wallis GMT+12:00</option>
                                    <option value="Pacific/Yap">Pacific/Yap GMT+10:00</option>
                                    <option value="Poland">Poland GMT+1:00</option>
                                    <option value="Portugal">Portugal GMT+0:00</option>
                                    <option value="ROK">ROK GMT+9:00</option>
                                    <option value="Singapore">Singapore GMT+8:00</option>
                                    <option value="SystemV/AST4">SystemV/AST4 GMT-4:00</option>
                                    <option value="SystemV/AST4ADT">SystemV/AST4ADT GMT-4:00</option>
                                    <option value="SystemV/CST6">SystemV/CST6 GMT-6:00</option>
                                    <option value="SystemV/CST6CDT">SystemV/CST6CDT GMT-6:00</option>
                                    <option value="SystemV/EST5">SystemV/EST5 GMT-5:00</option>
                                    <option value="SystemV/EST5EDT">SystemV/EST5EDT GMT-5:00</option>
                                    <option value="SystemV/HST10">SystemV/HST10 GMT-10:00</option>
                                    <option value="SystemV/MST7">SystemV/MST7 GMT-7:00</option>
                                    <option value="SystemV/MST7MDT">SystemV/MST7MDT GMT-7:00</option>
                                    <option value="SystemV/PST8">SystemV/PST8 GMT-8:00</option>
                                    <option value="SystemV/PST8PDT">SystemV/PST8PDT GMT-8:00</option>
                                    <option value="SystemV/YST9">SystemV/YST9 GMT-9:00</option>
                                    <option value="SystemV/YST9YDT">SystemV/YST9YDT GMT-9:00</option>
                                    <option value="Turkey">Turkey GMT+3:00</option>
                                    <option value="UCT">UCT GMT+0:00</option>
                                    <option value="US/Alaska">US/Alaska GMT-9:00</option>
                                    <option value="US/Aleutian">US/Aleutian GMT-10:00</option>
                                    <option value="US/Arizona">US/Arizona GMT-7:00</option>
                                    <option value="US/Central">US/Central GMT-6:00</option>
                                    <option value="US/East-Indiana">US/East-Indiana GMT-5:00</option>
                                    <option value="US/Eastern">US/Eastern GMT-5:00</option>
                                    <option value="US/Hawaii">US/Hawaii GMT-10:00</option>
                                    <option value="US/Indiana-Starke">US/Indiana-Starke GMT-6:00</option>
                                    <option value="US/Michigan">US/Michigan GMT-5:00</option>
                                    <option value="US/Mountain">US/Mountain GMT-7:00</option>
                                    <option value="US/Pacific">US/Pacific GMT-8:00</option>
                                    <option value="US/Pacific-New">US/Pacific-New GMT-8:00</option>
                                    <option value="US/Samoa">US/Samoa GMT-11:00</option>
                                    <option value="UTC">UTC GMT+0:00</option>
                                    <option value="Universal">Universal GMT+0:00</option>
                                    <option value="W-SU">W-SU GMT+3:00</option>
                                    <option value="WET">WET GMT+0:00</option>
                                    <option value="Zulu">Zulu GMT+0:00</option>
                                    <option value="EST">EST GMT-5:00</option>
                                    <option value="HST">HST GMT-10:00</option>
                                    <option value="MST">MST GMT-7:00</option>
                                    <option value="ACT">ACT GMT+9:30</option>
                                    <option value="AET">AET GMT+10:00</option>
                                    <option value="AGT">AGT GMT-3:00</option>
                                    <option value="ART">ART GMT+2:00</option>
                                    <option value="AST">AST GMT-9:00</option>
                                    <option value="BET">BET GMT-3:00</option>
                                    <option value="BST">BST GMT+6:00</option>
                                    <option value="CAT">CAT GMT+2:00</option>
                                    <option value="CNT">CNT GMT-4:30</option>
                                    <option value="CST">CST GMT-6:00</option>
                                    <option value="CTT">CTT GMT+8:00</option>
                                    <option value="EAT">EAT GMT+3:00</option>
                                    <option value="ECT">ECT GMT+1:00</option>
                                    <option value="IET">IET GMT-5:00</option>
                                    <option value="IST">IST GMT+5:30</option>
                                    <option value="JST">JST GMT+9:00</option>
                                    <option value="MIT">MIT GMT+13:00</option>
                                    <option value="NET">NET GMT+4:00</option>
                                    <option value="NST">NST GMT+12:00</option>
                                    <option value="PLT">PLT GMT+5:00</option>
                                    <option value="PNT">PNT GMT-7:00</option>
                                    <option value="PRT">PRT GMT-4:00</option>
                                    <option value="PST">PST GMT-8:00</option>
                                    <option value="SST">SST GMT+11:00</option>
                                    <option value="VST">VST GMT+7:00</option> --}}
                                    @foreach ( DateTimeZone::listIdentifiers() as $item )
                                    <option value={{ $item }} {{ $item == env('TIMEZONE')?'selected':'' }}>{{ $item }}</option>
                                    @endforeach
                                  </select>
                            </div>

                        </div>
                </div>

                 <div class="col-md-6">
                    <div class="col-12">
                        <label class="form-label" for="multicol-first-name">First Name</label>
                        <div class="card mb-4">

                            <input id="pac-input" class="form-control" type="text" placeholder="Search Box"
                            style="width: 300px; margin-top: 10px" />
                            <div class="card-body">
                                <div style="height: 370px !important" id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 row">
                    <div class="col-3">

                        <button id='submit' type="submit" class="btn btn-primary"> <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Submit</button>

                    </div>
                    <div class="col-3">

                        <a  href="../" class="btn btn-label-danger">Back</a>

                    </div>
                </div>

            </form>
        </div>



        {{-- بسم الله الرحمن الرحيم --}}


    </div>
    <!-- / Content -->
    @section('VendorsJS')
      <!-- The core Firebase JS SDK is always required and must be listed first -->
      {{-- AIzaSyBI9Dy68H76Ml1AW1D4oIdsR32z0PGE18Y   //////// Google Map API  --}}
        {{-- Map --}}
        <script type="text/javascript">
            var lng = 55.513641;
            $('#map_latitude').val(lat);
            var lat = 25.405216;
            $('#map_longitude').val(lng);

            var markers = [];
            var map;
            var myLatLng;

            function addAddressBar() {
               // event.preventDefault();
                // Create the search box and link it to the UI element.
                const input = document.getElementById("pac-input");
                const searchBox = new google.maps.places.SearchBox(input);

                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                // Bias the SearchBox results towards current map's viewport.
                map.addListener("bounds_changed", () => {

                    console.log('noooo');
                    // event.preventDefault();
                    searchBox.setBounds(map.getBounds());
                });

                let markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener("places_changed", () => {
                    console.log('noooo2');
                    const places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    // Clear out the old markers.
                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    const bounds = new google.maps.LatLngBounds();

                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }

                        const icon = {
                            //url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25),
                        };

                        // Create a marker for each place.
                        markers.push(
                            new google.maps.Marker({
                                map,
                                icon,
                                title: place.name,
                                position: place.geometry.location,
                            }),
                        );
                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            }

            function addYourLocationButton(map, marker) {
                var controlDiv = document.createElement('div');

                var firstChild = document.createElement('button');
                firstChild.style.backgroundColor = '#fff';
                firstChild.style.border = 'none';
                firstChild.style.outline = 'none';
                firstChild.style.width = '28px';
                firstChild.style.height = '28px';
                firstChild.style.borderRadius = '2px';
                firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
                firstChild.style.cursor = 'pointer';
                firstChild.style.marginRight = '10px';
                firstChild.style.padding = '0px';
                firstChild.title = 'Your Location';
                controlDiv.appendChild(firstChild);

                var secondChild = document.createElement('div');
                secondChild.style.margin = '5px';
                secondChild.style.width = '18px';
                secondChild.style.height = '18px';
                secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
                secondChild.style.backgroundSize = '180px 18px';
                secondChild.style.backgroundPosition = '0px 0px';
                secondChild.style.backgroundRepeat = 'no-repeat';
                secondChild.id = 'you_location_img';
                firstChild.appendChild(secondChild);

                google.maps.event.addListener(map, 'dragend', function() {
                    $('#you_location_img').css('background-position', '0px 0px');
                });

                firstChild.addEventListener('click', function() {
                    console.log('cleck');
                    event.preventDefault();
                    var imgX = '0';
                    var animationInterval = setInterval(function() {
                        if (imgX == '-18') imgX = '0';
                        else imgX = '-18';
                        $('#you_location_img').css('background-position', imgX + 'px 0px');
                    }, 500);
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords
                                .longitude);
                            marker.setPosition = latlng;
                            map.setCenter(latlng);
                            addMarker(latlng);
                            clearInterval(animationInterval);
                            $('#you_location_img').css('background-position', '-144px 0px');
                        });
                    } else {
                        clearInterval(animationInterval);
                        $('#you_location_img').css('background-position', '0px 0px');
                    }
                });

                controlDiv.index = 1;
                map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
            }

            function initMap() {

                //setMapOnAll({lng:parseFloat(lng), lat:parseFloat(lat)});
                console.log(lat);
                console.log(lng);
                //console.log(lng)

                myLatLng = {
                    lng: parseFloat(lng),
                    lat: parseFloat(lat)
                };
                //console.log(myLatLng)
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: myLatLng,
                });
                map.addListener('click', function(event) {
                    clearMarkers();
                    addMarker(event.latLng);
                    console.log(event.latLng);
                    document.getElementById("map_latitude").innerHTML = event.latLng
                        .lat(); //+ ',' + event.latLng.lng();
                });
                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: "",
                });
                addYourLocationButton(map, myLatLng);
                addAddressBar();

            }

            window.initMap = initMap;

            function addMarker(location) {
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });

                $('#map_latitude').val(location.lat().toFixed(6));
                $('#map_longitude').val(location.lng().toFixed(6));
                //console.log(location.lat().toFixed(6));
                markers.push(marker);
            }

            function clearMarkers() {
                setMapOnAll(null);
            }
            // Sets the map on all markers in the array.
            function setMapOnAll(map) {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(map);

                }
            }
        </script>
        {{-- <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script> --}}
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ $maps->server_key ?? ''}}&callback=initMap&libraries=places&v=weekly"
            defer>
        </script>
        <!-- Vendors JS -->
        <script src="{{ asset('build/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/moment/moment.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/select2/select2.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('build/assets/js/main.js') }}"></script>

        <!-- Page JS -->
        <script src="{{ asset('build/assets/js/form-layouts.js') }}"></script>

        <script>
            $(document).ready(function() {
                    $(document).on('submit', 'form', function() {
                        $('button').attr('disabled', 'disabled');
                        $(".spinner-border").removeClass("d-none");
                    });
                });
        </script>
    @endsection
</x-app-layout>
