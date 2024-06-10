<?php

namespace App\Http\Controllers\Admin\WhatsappSmsSettings;

use App\Http\Controllers\Controller;
use App\Models\WhatsappSmsSetting;
use Illuminate\Http\Request;

class WhatsappSmsSettingsController extends Controller
{
    public function whatsapp_settings(){
        //$data = MailSetting::first();
        $data = WhatsappSmsSetting::first();
        return view('admin.whatsapp_sms_settings.whatsapp',compact('data'));
    }

    public function sms_settings(){
        //$data = FirebasePushNotification::first();

        return view('admin.whatsapp_sms_settings.sms');
    }

    public function updateWhatsappConfig(Request $request){
        $data = WhatsappSmsSetting::first();
        if($data == null){
            $whatspp=new WhatsappSmsSetting();
            $whatspp->api_url=$request->api_url;
            $whatspp->instance_id=$request->instance_id;
            $whatspp->token=$request->token;
            $whatspp->save();
            toastr()->success('Success');
         }else{
            $data->api_url=$request->api_url;
            $data->instance_id=$request->instance_id;
            $data->token=$request->token;

            $data->save();
            toastr()->success('Success');
         }


        return redirect()->back();
    }
}
