<?php

namespace App\Http\Controllers\Admin\FirebaseSettings;

use App\Http\Controllers\Controller;
use App\Models\FirebasePushNotification;
use Illuminate\Http\Request;

class FirebaseSettingsController extends Controller
{
    public function push_notification(){
        $data = FirebasePushNotification::first();

        return view('admin.firebase_settings.push_notification',compact('data'));
    }
    public function config_notification(){
        $data = FirebasePushNotification::first();
        return view('admin.firebase_settings.firebase_config',compact('data'));
    }


    public function updatePushNotification(Request $request)
    {
        $data = FirebasePushNotification::query()->find(1);

        //return [$request->all()];

        if($data == null){
            // return "null";
            $firebasePushNotification= new FirebasePushNotification();
            $firebasePushNotification
                ->setTranslation('pending', 'en', $request->pending_english)
                ->setTranslation('pending', 'ar', $request->pending_arabic);
            $firebasePushNotification
                ->setTranslation('confirm', 'en', $request->confirm_english)
                ->setTranslation('confirm', 'ar', $request->confirm_arabic);
            $firebasePushNotification
                ->setTranslation('delivere', 'en', $request->delivere_english)
                ->setTranslation('delivere', 'ar', $request->delivere_arabic);
            $firebasePushNotification
                ->setTranslation('delay', 'en', $request->delay_english)
                ->setTranslation('delay', 'ar', $request->delay_arabic);
            $firebasePushNotification
                ->setTranslation('transfer', 'en', $request->transfer_english)
                ->setTranslation('transfer', 'ar', $request->transfer_arabic);
            $firebasePushNotification
                ->setTranslation('cancel', 'en', $request->cancel_english)
                ->setTranslation('cancel', 'ar', $request->cancel_arabic);
            $firebasePushNotification
                ->setTranslation('damage', 'en', $request->damage_english)
                ->setTranslation('damage', 'ar', $request->damage_arabic);
             $firebasePushNotification->save();
         }else{
            $data->pending=['en'=>$request->pending_english, 'ar'=>$request->pending_arabic];
            $data->confirm=['en'=>$request->confirm_english, 'ar'=>$request->confirm_arabic];
            $data->delivere=['en'=>$request->delivere_english, 'ar'=>$request->delivere_arabic];
            $data->delay=['en'=>$request->delay_english, 'ar'=>$request->delay_arabic];
            $data->transfer=['en'=>$request->transfer_english, 'ar'=>$request->transfer_arabic];
            $data->cancel=['en'=>$request->cancel_english, 'ar'=>$request->cancel_arabic];
            $data->damage=['en'=>$request->damage_english, 'ar'=>$request->damage_arabic];
            $data->save();
            toastr()->success('Success');
         }

        return redirect()->back();

    }
    public function updateConfig(Request $request)
    {
        $data = FirebasePushNotification::first();


        if($data == null){
           // return "null";
            $firebasePushNotification= new FirebasePushNotification();
            $firebasePushNotification->server_key=$request->server_key;
            $firebasePushNotification->api_key=$request->api_key;
            $firebasePushNotification->project_id=$request->project_id;
            $firebasePushNotification->auth_domain=$request->auth_domain;
            $firebasePushNotification->storage_bucket=$request->storage_bucket;
            $firebasePushNotification->messaging_sender_id=$request->messaging_sender_id;
            $firebasePushNotification->app_id=$request->app_id;
            $firebasePushNotification->measurment_id=$request->measurement_id;
            $firebasePushNotification->save();
            toastr()->success('Success');
            //return [$firebasePushNotification];
        }else{
            $data->server_key=$request->server_key;
            $data->api_key=$request->api_key;
            $data->project_id=$request->project_id;
            $data->auth_domain=$request->auth_domain;
            $data->storage_bucket=$request->storage_bucket;
            $data->messaging_sender_id=$request->messaging_sender_id;
            $data->app_id=$request->app_id;
            $data->measurment_id=$request->measurement_id;
            $data->save();
            toastr()->success('Success');
            //return [$data];
            //return 0;
        }


        return redirect()->back();

    }

}
