<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Settings;
class ShopFrontController extends Controller
{

  public function shopscript(Request $request){
      $contents = View::make('shopjs')->with('openlocation', 1);
      $response = Response::make($contents, 200);
      $response->header('Content-Type', 'application/javascript');
      return $response;
  }

  public function StoreLocations(Request $request)
  {
      $shop =$request->shop;
      $searchWord = strtolower($request->keyword);
      $settings = Settings::where('shop',$shop)->first();
      if($settings){
        date_default_timezone_set($settings->timezone);
      }
      $daysArray=['monday'=>'Mon','tuesday'=>'Tue','wednesday'=>'Wed','thursday'=>'Thur','friday'=>'Fri','saturday'=>'Sat','sunday'=>'Sun'];
      $apiKey = $settings->google_api_key;
      // $query = DB::table('locations')->whereRaw('LOWER(`location_name`) LIKE ? ',['%' .$request->keyword . '%'])->get();

      $select =" SELECT * FROM locations WHERE lower(location_name) like '%".$searchWord."%'
      OR lower(address) like '%".$searchWord."%'
      OR lower(address1) like '%".$searchWord."%'
       OR lower(city) like '%".$searchWord."%'
       OR lower(state) like '%".$searchWord."%'
       OR lower(country) like '%".$searchWord."%'
       OR lower(zip_code) like '%".$searchWord."%'";
       $locations = DB::select($select);

      foreach ($locations as $key => $location){
        $currentDay = lcfirst(Carbon::now()->format('l'));
        $stm =  DB::table('store_timing')->select('open_time','days_name','close_time')->where(['location_id'=>$location->shopify_location_id])->get();
        foreach ($stm as $tm) {
          $tm->open_time =  date('h:i a', strtotime($tm->open_time));
          $tm->close_time = date('h:i a', strtotime($tm->close_time));
          $tm->days_name = $daysArray[$tm->days_name];
        }
        $location->store_timing = $stm;
        $timings = DB::table('store_timing')->select('open_time','close_time')->where(['days_name' => $currentDay,'location_id'=>$location->shopify_location_id,'shop'=>$shop])->first();
        $isOpen = false;
        if($timings){
          $isOpen = Carbon::now()->between(Carbon::parse($timings->open_time),Carbon::parse($timings->close_time));
        }
        $openingMessage="Closed Now";
        if($timings && !$isOpen){
          $openingMessage="Closed Now - Opens at ".date('h:i A', strtotime($timings->open_time));
        }
        if($isOpen){
          $openingMessage = "Open Now - Closes at ".date('h:i A', strtotime($timings->close_time));
        }
        $location->opening_message = $openingMessage;
        if(is_null($location->geo_latitiude)){
          $locationAddress = $location->address." ".$location->address1." ".$location->city." ".$location->state." ".$location->country;
          $locationLatLong = getlatlongbyaddress($locationAddress,$apiKey);
          $location->geo_latitiude = $locationLatLong['lat'];
          $location->geo_langitude = $locationLatLong['long'];
        }
        unset($location->email);
        unset($location->shop);
        unset($location->shop_id);
        unset($location->password);
      }
      echo json_encode(['locations'=>$locations]);
  }

  public function SearchProductInvetory(Request $request)
  {
    $shop =$request->shop;
    $settings = Settings::where('shop',$shop)->first();
    $apiKey = $settings->google_api_key;
    $product_id = $request->pid;

    $ShopifyApiClient =User::where('name',$request->shop)->first();
    $product_details = (object)$ShopifyApiClient->api()->request('GET', '/admin/api/'.getYear().'/products/'.$product_id.'.json');
    $itemsArray=[];
    foreach ($product_details->body->container['product']['variants'] as  $variant) {
      if(!in_array($variant['id'],$itemsArray)){
        $itemsArray[] = $variant['id'];
      }
    }
    $data = DB::table('tbl_inventory')
          ->where(['shopify_product_id'=>$product_id])
          ->where('available_qty', '>',0)
          ->whereIn('shopify_variant_id', $itemsArray)
          ->get();
    $locations = DB::table('locations')->get();
    $locationsArray=[];
    foreach ($locations as $lk) {
      unset($lk->id);
      unset($lk->email);
      unset($lk->shop);
      unset($lk->shop_id);
      unset($lk->password);
      unset($lk->super_admin_status);
      unset($lk->store_hours);
      unset($lk->updated_at);
      unset($lk->created_at);
      if(is_null($lk->geo_latitiude)){
        $locationAddress = $lk->address." ".$lk->address1." ".$lk->city." ".$lk->state." ".$lk->country;
        $locationLatLong = getlatlongbyaddress($locationAddress,$apiKey);
        $lk->geo_latitiude = $locationLatLong['lat'];
        $lk->geo_langitude = $locationLatLong['long'];
      }
      $locationsArray[$lk->shopify_location_id]=$lk;
    }
    $returnArray=[];
    foreach ($data as $singleRow){
      unset($singleRow->id);
      unset($singleRow->shop_id);
      unset($singleRow->shop);
      unset($singleRow->event);
      unset($singleRow->inventory_item_id);
      unset($singleRow->is_open);
      unset($singleRow->is_geo_manually);
      if(!isset($returnArray[$singleRow->shopify_variant_id])){
        $returnArray[$singleRow->shopify_variant_id]=[];
      }
      $returnArray[$singleRow->shopify_variant_id][]=['inventory_details'=>$singleRow,'location_details'=>$locationsArray[$singleRow->location_id]];
    }
    echo json_encode(['availability'=>$returnArray]);

  }


  public function SearchLocationsInventory(Request $request)
  {
    $cart = json_decode($request->cart);
    $itemsArray=[];
    foreach ($cart->items as  $item) {
      if(!in_array($item->id,$itemsArray)){
        $itemsArray[] = $item->id;
      }
    }
    $shop = $request->shop;
    $settings = Settings::where('shop',$shop)->first();
    $apiKey = $settings->google_api_key;
    $data = DB::table('tbl_inventory')
          ->where('available_qty', '>',0)
          ->whereIn('shopify_variant_id', $itemsArray)
          ->get();
    $locations = DB::table('locations')->get();
    $locationsArray=[];
    foreach ($locations as $lk) {
      unset($lk->id);
      unset($lk->email);
      unset($lk->shop);
      unset($lk->shop_id);
      unset($lk->password);
      unset($lk->super_admin_status);
      unset($lk->store_hours);
      unset($lk->updated_at);
      unset($lk->created_at);
      if(is_null($lk->geo_latitiude)){
        $locationAddress = $lk->address." ".$lk->address1." ".$lk->city." ".$lk->state." ".$lk->country;
        $locationLatLong = getlatlongbyaddress($locationAddress,$apiKey);
        $lk->geo_latitiude = $locationLatLong['lat'];
        $lk->geo_langitude = $locationLatLong['long'];
      }
      $locationsArray[$lk->shopify_location_id]=$lk;
    }
    $returnArray=[];
    foreach ($data as $singleRow) {
      unset($singleRow->id);
      unset($singleRow->shop_id);
      unset($singleRow->shop);
      unset($singleRow->event);
      unset($singleRow->inventory_item_id);
      unset($singleRow->is_open);
      unset($singleRow->is_geo_manually);
      if(!isset($returnArray[$singleRow->location_id])){
        $returnArray[$singleRow->location_id]=[];
      }
      $returnArray[$singleRow->location_id]['items'][]=$singleRow;
      $returnArray[$singleRow->location_id]['address']=$locationsArray[$singleRow->location_id];
    }
    echo json_encode(['locations'=>$returnArray]);

  }



}
