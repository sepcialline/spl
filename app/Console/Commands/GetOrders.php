<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use function App\Helpers\getOrders;

class GetOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get order from store';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        getOrders();
    }
}
