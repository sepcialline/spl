<?php

namespace App\Helpers;

use App\Models\Company;
use App\Models\ShopifyConfig;
use App\Models\ShopifyOrder;
use App\Models\ShopifyOrderContent;
use App\Models\VendorCompany;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GetOrdersHelper
{
    public static function getOrders()
    {
        $companies = VendorCompany::where('has_api',1)->get();
        foreach ($companies as $company) {
            $company_id = $company->id;
            # code...
            $config = ShopifyConfig::where('company_id', $company->id)->first();
            $company['config'] = $config;
            if ($config) {
                $response = Http::withHeaders([
                    'X-Shopify-Access-Token' => $config->access_token,

                ])->get('https://' . $config->store_name . '/admin/api/2023-10/orders.json?status=open');

                $count =  Http::withHeaders([
                    'X-Shopify-Access-Token' => $config->access_token,

                ])->get('https://' . $config->store_name . '/admin/api/2023-10/orders/count.json?status=open');
                $data = json_decode($response->body());
                $company['count']=  json_decode($count->body());
                // dd(count($company->orders));

                //return response($data,200);
                // dd($data->orders[0]);
                dd($data->orders);
                foreach ($data->orders as $order) {
                    # code...
                    ShopifyOrder::updateOrCreate(
                        ['order_number' => $order->order_number, 'app_id' => $order->app_id],
                        [
                            'order_id' => $order->id,
                            'company_id' => $company_id,
                            'order_number' => $order->order_number,
                            'customer_name' => $order->shipping_address->name ?? '-',
                            'phone_no' => $order->phone ?? '-',
                            'email' => $order->email ?? '-',
                            'payment_gateway_names'=>$order->payment_gateway_names[0],
                            'address' => $order->shipping_address->address1 ?? '-',
                            'city' => $order->shipping_address->city ?? '-',
                            'emirate' => $order->shipping_address->province ?? '-',
                            'longitude' => $order->shipping_address->longitude ?? '-',
                            'latitude' => $order->shipping_address->latitude ?? '-',
                            'subtotal_price' => $order->subtotal_price ?? '-',
                            'discount' => $order->total_discounts ?? '-',
                            'shipping_price' => $order->total_shipping_price_set->shop_money->amount ?? '-',
                            'tax' => $order->total_tax ?? '-',
                            'total_price' => $order->total_price ?? '-',
                            'currency' => $order->currency ?? '-',
                            'financial_status' => $order->financial_status,
                            'created_at'=> Carbon::parse($order->created_at)->format('Y-m-d h:m:i')
                        ]
                    );

                    foreach ($order->line_items as $item) {
                        ShopifyOrderContent::updateOrCreate(
                            [
                                'order_id' => $order->id,
                                'product_name' => $item->name,
                                'quantity' => $item->fulfillable_quantity
                            ],
                            [
                                'order_id' => $order->id,
                                'product_name' => $item->name,
                                'quantity' => $item->fulfillable_quantity
                            ]
                        );
                    }
                }
            }
        }


        return $companies;
    }

    public static function closeOrder($company_id, $order_id, $order_number)
    {
        $config = ShopifyConfig::query()->where('company_id', $company_id)->first();
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $config->access_token,

        ])->post('https://' . $config->store_name . '.myshopify.com/admin/api/2023-10/orders/' . $order_id . '/close.json',);

        $resp_decoded = json_decode($response);
        //dd($resp_decoded);
        //return response($response,200);
        $order = ShopifyOrder::query()->where('order_number', $order_number)->first();
        $order->status = 1;
        $order->save();
    }
}
