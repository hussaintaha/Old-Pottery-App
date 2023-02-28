<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use DB;
use URL;
use Session;
use App\User;
use App\locations;
use App\Settings;

class LocationUser extends Controller
{

  public function Login()
  {
    if (Session::has('userData')){
        return redirect()->route('dashboard');
    }else{
      return View::make('LocationUser.login');
    }
  }

  public function Dashboard(Request $request)
  {
    if (Session::has('userData')){
        $location_id = Session::get('userData')->shopify_location_id;
        $shop = Session::get('userData')->shop;
        $ShopifyApiClient =User::where('name',$shop)->first();
        $shopdetails = $ShopifyApiClient->api()->request('GET', '/admin/api/'.getYear().'/shop.json');
        $orders = DB::table('location_orders')->where(['shop' => $shop])->where(['shopify_location_id' => $location_id])->get();
        $new_orders=[];
        $settings = Settings::where('shop',$shop)->first();
        if($settings){
          date_default_timezone_set($settings->timezone);
        }
        $distinctOrders = DB::table('location_orders')->select('order_number','status')->distinct()->where(['shop' => $shop])->where(['shopify_location_id' => $location_id])->get();
        $checkArray=[];
        foreach ($distinctOrders as $ord) {
          $checkArray[$ord->order_number]=$ord;
        }
        $returnArray=[];
        foreach ($orders as  $order) {
          if($checkArray[$order->order_number]->status == 0){
            $returnArray['pending'][$order->order_number][]=$order;
          }
          if($checkArray[$order->order_number]->status == 1){
            $returnArray['processing'][$order->order_number][]=$order;
          }
          if($checkArray[$order->order_number]->status == 2){
            $returnArray['ready'][$order->order_number][]=$order;
          }
        }
      return View::make('LocationUser.new_dashboard',[
        'orders'=>$returnArray,
        'page'=>'dashboard',
        'shop'=>$shop,
        'currency'=>$shopdetails['body']['container']['shop']['currency']
      ]);

    }else{
      return redirect()->route('login');
    }
  }

  public function Orders(Request $request)
  {
    if (Session::has('userData')){
      $status = $request->status;
      $shop = Session::get('userData')->shop;
      $ShopifyApiClient =User::where('name',$shop)->first();
      $shopdetails = $ShopifyApiClient->api()->request('GET', '/admin/api/'.getYear().'/shop.json');
      $settings = Settings::where('shop',$shop)->first();
      if($settings){
        date_default_timezone_set($settings->timezone);
      }
      $location_id = Session::get('userData')->shopify_location_id;
      $orders = DB::table('location_orders')->where(['shopify_location_id'=>$location_id,'status'=>$status])->orderBy('id', 'DESC')->get();
      $returnArray=[];
      foreach ($orders as  $order){
        $returnArray[$order->order_number][]=$order;
      }
      return View::make(ReturnViewPage($status),[
        'orders'=>$returnArray,
        'page'=>StatusPage($status),
        'shop'=>$shop,
        'currency'=>$shopdetails['body']['container']['shop']['currency']
      ]);
    }else{
      return redirect()->route('login');
    }
  }


  public function OrderDetailsPage(Request $request)
  {
    if (Session::has('userData')){
      $id = $request->order_id;
      $details = DB::table('location_orders')->where(['id'=>$id])->first();
      $shop = Session::get('userData')->shop;
      $ShopifyApiClient =User::where('name',$shop)->first();
      $order = $ShopifyApiClient->api()->request('GET','/admin/api/'.getYear().'/orders/'.$details->order_number.'.json');
      $orderdetails = $order['body']['container']['order'];
      $settings = Settings::where('shop',$shop)->first();
      if($settings){
        date_default_timezone_set($settings->timezone);
      }
      return View::make('LocationUser.order_full_details',[
        'order'=>$orderdetails,
        'page'=>'order',
      ]);
    }else{
      return redirect()->route('login');
    }
  }


  public function PosPrint(Request $request)
  {

    if (Session::has('userData')){
      $id = $request->order_id;
      $shopify_location_id = Session::get('userData')->shopify_location_id;
      $details = DB::table('location_orders')->where(['id'=>$id])->first();
      $shop = Session::get('userData')->shop;
      $ShopifyApiClient =User::where('name',$shop)->first();
      $det = DB::table('location_orders')->where(['id'=>$id])->first();
      $orders = DB::table('location_orders')->where(['order_number'=>$det->order_number,'shopify_location_id'=>$shopify_location_id])->pluck('Shopify_variant_id')->toArray();
      $order = $ShopifyApiClient->api()->request('GET','/admin/api/'.getYear().'/orders/'.$details->order_number.'.json');
      $shopdetails = $ShopifyApiClient->api()->request('GET','/admin/api/'.getYear().'/shop.json');
      $items=[];
      foreach ($order['body']['container']['order']['line_items'] as $line) {
        if(in_array($line['variant_id'],$orders)){
          $items[]=$line;

        }
        if($line['variant_id'] == $details->Shopify_variant_id){
            $item[]=$line;
        }
      }
      return View::make('LocationUser.posinvoice',[
        'shop_name'=>$shopdetails['body']['container']['shop']['name'],
        'page'=>'a_orders',
        'order'=>$details,
        'item'=>$item,
        'items'=>$items,
        'currency'=>$order['body']['container']['order']['currency']
      ]);
    }else{
      return redirect()->route('login');
    }

  }

  public function Settings()
  {
    if (Session::has('userData')){
      $location_id = Session::get('userData')->shopify_location_id;
      $shop = Session::get('userData')->shop;
      $settings = Settings::where('shop',$shop)->first();
      $apiKey = $settings->google_api_key;
      $orders = DB::table('location_orders')->where(['shopify_location_id'=>$location_id,'status'=>1])->orderBy('id', 'DESC')->get();
      $ldetails = Session::get('userData');
      $locationlat = $ldetails->geo_latitiude;
      $locationlang = $ldetails->geo_langitude;
      if(is_null($ldetails->geo_latitiude)){
        $locationAddress = $ldetails->address." ".$ldetails->address1." ".$ldetails->city." ".$ldetails->state." ".$ldetails->country;
        $locationLatLong = getlatlongbyaddress($locationAddress,$apiKey);
        $locationlat = $locationLatLong['lat'];
        $locationlang = $locationLatLong['long'];
      }
      return View::make('LocationUser.settings',['page'=>'settings','lat'=>$locationlat,'long'=>$locationlang,'api_key'=>$apiKey]);
    }else{
      return redirect()->route('login');
    }

  }

  public function Logout()
  {
    Session::forget('userData');
    return redirect()->route('login');
  }




  public function UpdateSettings(Request $request)
  {
      $update = DB::table('locations')->where(['id'=>Session::get('userData')->id])->update(['is_open'=>$request->status]);
      if($update){
        echo json_encode(['code'=>200,'msg'=>"Status Changed"]);
      }else{
        echo json_encode(['code'=>100,'msg'=>"Someting went wrong Please Try after Sometime"]);
      }
  }

  public function UpdateOrderStatus(Request $request)
  {
    $shop = Session::get('userData')->shop;
    $shopify_location_id = Session::get('userData')->shopify_location_id;
    $settings = Settings::where('shop',$shop)->first();
    if($settings){
      date_default_timezone_set($settings->timezone);
    }
      $line=$request->id;
      $det = DB::table('location_orders')->where(['id'=>$line])->first();
      $orders = DB::table('location_orders')->where(['order_number'=>$det->order_number,'shopify_location_id'=>$shopify_location_id])->get();
      foreach ($orders as  $order) {
        $update = DB::table('location_orders')
                  ->where(['id'=>$order->id])
                  ->update(['status'=>$request->status,'delivered_time'=>date('Y-m-d H:i:s')]);
      }
      echo json_encode(['code'=>200,'msg'=>"Order Accepted"]);
  }
  public function AcceptOrder(Request $request)
  {
    $shop = Session::get('userData')->shop;
    $shopify_location_id = Session::get('userData')->shopify_location_id;
    $settings = Settings::where('shop',$shop)->first();
    if($settings){
      date_default_timezone_set($settings->timezone);
    }
    $line = $request->line;
    $det = DB::table('location_orders')->where(['id'=>$line])->first();
    $orders = DB::table('location_orders')->where(['order_number'=>$det->order_number,'shopify_location_id'=>$shopify_location_id])->get();
    foreach ($orders as $key => $order) {
        $rowid = $order->id;
        $variantid = $order->Shopify_variant_id;
        $qty = $order->product_quantity;
        $ShopifyApiClient =User::where('name',$shop)->first();
        $inv = DB::table('tbl_inventory')
              ->where(['location_id'=>$shopify_location_id,'shopify_variant_id'=>$variantid,'shop_id'=>$ShopifyApiClient->id])
              ->where('available_qty', '>',0)->first();
        if($inv){
          $newqty = $inv->available_qty - $qty;
          $inventory_item_id = $inv->inventory_item_id;
          $adjustment = [
            "location_id" => $shopify_location_id,
            "inventory_item_id" => $inventory_item_id,
            "available_adjustment" => $newqty
          ];
          try {
            $adjust = $ShopifyApiClient->api()->request('POST','/admin/api/'.getYear().'/inventory_levels/adjust.json', $adjustment);
            DB::table('location_orders')->where(['id'=>$rowid])->update(['status'=>1,'accepted_time'=>date('Y-m-d H:i:s')]);
          } catch (\Exception $e) {
          }
        }else{
        }
    }
    echo json_encode(['code'=>200,'msg'=>"Order Accepted"]);
  }


  public function ValidateUser(Request $request)
  {
    $email = $request->email;
    $password = $request->password;
    $query = DB::table('locations')->where('email', '=', $email)->where('password', '=', $password);
    $users_count = $query->count();
    if($users_count > 0){
      $data = $query->first();
      Session::put('userData', $data);
      $return = ['code'=>200,'msg'=>'User Validated'];
    }else{
      $return = ['code'=>100,'msg'=>'Not A Valid User'];
    }
    echo json_encode($return);
  }


}
