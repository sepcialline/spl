<?php

namespace App\Http\Controllers\Admin\MailSettings;

use App\Http\Controllers\Controller;
use App\Models\MailSetting;
use Illuminate\Http\Request;

class MailSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function mail_config(){
        $data = MailSetting::first();

        return view('admin.mail_settings.mail_config',compact('data'));
    }

    public function mail_test(){
        //$data = FirebasePushNotification::first();

        return view('admin.mail_settings.mail_test');
    }

    public function updateMailSetting(Request $request)
    {
        $data = MailSetting::query()->find(1);

        if($data == null){
            $mail_setting=new MailSetting();
            $mail_setting->mailer_name=$request->mailer_name;
            $mail_setting->host=$request->host;
            $mail_setting->driver=$request->driver;
            $mail_setting->port=$request->port;
            $mail_setting->username=$request->username;
            $mail_setting->email_id=$request->email_id;
            $mail_setting->encryption=$request->encryption;
            $mail_setting-> password=$request->password;
            $mail_setting->save();
            toastr()->success('Success');
         }else{
            $data->mailer_name=$request->mailer_name;
            $data->host=$request->host;
            $data->driver=$request->driver;
            $data->port=$request->port;
            $data->username=$request->username;
            $data->email_id=$request->email_id;
            $data->encryption=$request->encryption;
            $data->password=$request->password;
            $data->save();
            toastr()->success('Success');
         }

        return redirect()->back();

    }
}
