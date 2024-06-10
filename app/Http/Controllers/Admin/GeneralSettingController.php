<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MapSetting;
use Illuminate\Support\Facades\File;

class GeneralSettingController extends Controller
{
    public function setting(){
        //echo 'aaa';
        return view('admin.setting.setting');
    }
    public function softwareSetting(){

        $data = Settings::first();
        $maps=MapSetting::first();
        //Settings::where('id',$data['id'])->update($data);
        //echo $data;
        return view('admin.setting.softwareSetting',compact('data','maps'));
    }
    function updateEnvFile(array $data)
    {
        // Read the contents of the .env file
        $envFile = base_path(".env");
        $contents = File::get($envFile);

        // Split the contents into an array of lines
        $lines = explode("\n", $contents);

        // Loop through the lines and update the values
        foreach ($lines as &$line) {
            // Skip empty lines and comments
            if (empty($line) || str_starts_with($line, "#")) {
                continue;
            }

            // Split each line into key and value
            $parts = explode("=", $line, 2);
            $key = $parts[0];

            // Check if the key exists in the provided data
            if (isset($data[$key])) {
                // Update the value
                $line = $key . "=" . $data[$key];
                unset($data[$key]);
            }
        }

        // Append any new keys that were not present in the original file
        foreach ($data as $key => $value) {
            $lines[] = $key . "=" . $value;
        }

        // Combine the lines back into a string
        $updatedContents = implode("\n", $lines);

        // Write the updated contents back to the .env file
        File::put($envFile, $updatedContents);
    }

    public function updateSettings(Request $request)
    {



           // return [env('DEFAULT_LANGUAGE'),env('TIMEZONE')];
        // $oldValue=env($key);
        // if(file_exists($path)){

        //     file_put_contents($path,str_replace(
        //         $key.'='.$oldValue.'',
        //         $key.'='.'aaaaa'.'',
        //         file_get_contents($path)
        //     ));
        //     $newVal=env($key);
        //     return [$newVal];
        // }

       $data = Settings::query()->find(1);


        if($request->file()){
            if($request->hasFile('english_logo')){
                $english_logo_name = $request->english_logo != null ? time().'_'.$request->english_logo->getClientOriginalName():$data->logo_en;
                $data->	logo_en=$english_logo_name;
                $request->english_logo->move(public_path('build/assets/img/uploads/settings'), $english_logo_name);
            }

           if($request->hasFile('arabic_logo')){
                $arabic_logo_name = $request->arabic_logo!=null?time().'_'.$request->arabic_logo->getClientOriginalName():$data->logo_ar;
                $data->logo_ar=$arabic_logo_name;
                $request->arabic_logo->move(public_path('build/assets/img/uploads/settings'), $arabic_logo_name);
            }

            if($request->hasFile('favicon')){
                $favicon_name = time().'_'.$request->favicon->getClientOriginalName();

                $data->favicon=$favicon_name;
                $request->favicon->move(public_path('build/assets/img/uploads/settings'), $favicon_name);
            }

        }else{
          //  echo 'No';
        }

        $data
            ->setTranslation('name', 'en', $request->english_company_name)
            ->setTranslation('name', 'ar', $request->arabic_company_name);
        $data
            ->setTranslation('description', 'en', $request->english_description)
            ->setTranslation('description', 'ar', $request->arabic_description);
        $data
            ->setTranslation('address', 'en', $request->english_address)
            ->setTranslation('address', 'ar', $request->arabic_address);
        $data->map_longitude=$request->map_longitude;
        $data->map_latitude=$request->map_latitude;
        $data->timezone=$request->timezone;
        $data->tax_percentage=$request->tax_percentage;
        $data->landline=$request->landline;
        $data->mobile=$request->mobile;
        $data->tax=$request->tax;
        $data->default_language=$request->default_language;
        $data->save();
        self::updateEnvFile([
            "TIMEZONE" => $request->timezone,
            "DEFAULT_LANGUAGE" => $request->default_language,
            ]);


        return redirect()->back();
        //return view('admin.setting.softwareSetting',compact('data'));
        //
    }




}
