<?php

namespace App\Console\Commands;

use App\Models\Rider;
use Illuminate\Console\Command;
use Flasher\Laravel\Http\Request;
use App\Events\RiderLocationUpdated;
use Illuminate\Support\Facades\Auth;
use Adrianorosa\GeoLocation\GeoLocation;
use PhpParser\Node\Expr\Cast\Double;

class getCurrnetLocationRider extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seconds:get-currnet-location-rider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get lat lng for Auth rider every seconds';

    public function handle()
    {


        $riders = Rider::where('status',1)->where('ip_address','!=',Null)->get();


        foreach ($riders as $rider) {

            // $this->info($rider->ip_address);
            // if ($rider->ip_address != Null) {
                $clientIpAddress = Request()->getClientIp();

                Rider::find($rider->id)->update([
                    'ip_address' => $clientIpAddress
                ]);
                $userIp = Request()->getClientIp();

                $details = GeoLocation::lookup($userIp);
                // $auth_rider = Rider::where('id', $rider->id())->first();

                $rider->update([
                    'lat' => $details->getLatitude(),
                    'lng' => $details->getLongitude(),
                ]);

                event(new RiderLocationUpdated($rider->lat, $rider->lng));

                $this->info($rider->lat . ' ' . $rider->lng . ' Update has been send successfully');
            // }else{
                // $this->info($riders . 'no');

            // }
        }
        // $this->info($riders);
    }
}
