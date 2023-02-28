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
use App\locations;
use App\Days;
use App\Settings;
use App\Storetiming;
use App\Order;
use URL;

class OrderController extends Controller
{


  public function orderwebhook(Request $request){
    $response = file_get_contents('php://input');
    $data = json_decode($response);
    $shop = $request->header('x-shopify-shop-domain');
    $ShopifyApiClient = User::where('name',$shop)->first();
    $settings = Settings::where('shop',$shop)->first();
    if($settings){
       date_default_timezone_set($settings->timezone);
     }
    foreach ($data->line_items as  $item){
      $hasClocation=false;
      if(count($item->properties) > 0){
        foreach ($item->properties as $prop) {
          if($prop->name == 'location'){
            $location_id = $prop->value;
            $hasClocation = true;
            break;
          }
        }
      }
      if($hasClocation){
          $variant_id = $item->variant_id;
          $product_id = $item->product_id;
          $itemDetails = DB::table('tbl_inventory')->where(['shop_id' =>$ShopifyApiClient->id,'shopify_product_id'=>$product_id,'shopify_variant_id'=>$variant_id,'location_id'=>$location_id])->first();
                if($itemDetails){
                  $inventory_item_id = $itemDetails->inventory_item_id;
                  $newqty = $itemDetails->available_qty - $item->quantity;
                  $adjustment = ["location_id" => $location_id,"inventory_item_id" => $inventory_item_id,"available_adjustment" => $newqty];
                  try {
                      // $adjust = $ShopifyApiClient->api()->request('POST','/admin/api/'.getYear().'/inventory_levels/adjust.json', $adjustment);
                      $insertArray = [
                        'shop' => $shop,
                        'shopify_location_id' => $location_id,
                        'order_number' => $data->id,
                        'order_name' => $data->name,
                        'customer_name' => $data->customer->first_name." ".$data->customer->last_name,
                        'Shopify_product_id' => $item->product_id,
                        'Shopify_variant_id' => $item->variant_id,
                        'product_title' => $item->title."  ".$item->variant_title,
                        'product_quantity' => $item->quantity,
                        'status' => 0,
                        'order_date' => date('Y-m-d H:i:s',strtotime($data->created_at)),
                        'financial_status' => $data->financial_status,
                        'item_total' => $item->price * $item->quantity,
                        'customer_full_details' => json_encode($data->customer),
                        'payment_method' => $data->gateway,
                        'order_note' => $data->note,
                      ];
                  if(count($data->shipping_lines) > 0){
                    $insertArray['shipping_address'] = json_encode($data->shipping_lines);
                    $insertArray['shipping_type'] = 'shopify';
                  }else{
                    $insertArray['shipping_address'] = json_encode($data->shipping_address);
                    $insertArray['shipping_type'] = 'custom';
                  }
                  DB::table('location_orders')->insert($insertArray);
                } catch (\Exception $e) {
                }
              }
        }
     }
     DB::table('webhooks')->insert(['event' => 'order-created','shop_id'=>$shop,'data' => $response]);
     http_response_code(200);
  }


  public function Test()
  {

    $variant_id = 36756460667040;
    $product_id = 5508516937888;
    $item_id = 38693737726112;

    $json='{"locations":[{"id":50472550560,"name":"Bonita Springs","address1":"3302 Bonita Beach Road Southwest","address2":"","city":"Bonita Springs","zip":"34134","province":"FL","country":"US","phone":"+12396762880","created_at":"2020-07-17T14:34:26-05:00","updated_at":"2020-07-17T14:34:27-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50467373216,"name":"Casselberry","address1":"204 Florida 436","address2":"","city":"Casselberry","zip":"32707","province":"FL","country":"US","phone":"+14076441460","created_at":"2020-07-17T13:20:22-05:00","updated_at":"2020-07-17T13:20:23-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50470027424,"name":"Charlotte","address1":"2500 Sardis Road North","address2":"","city":"Charlotte","zip":"28227","province":"NC","country":"US","phone":"+17048144905","created_at":"2020-07-17T14:04:47-05:00","updated_at":"2020-07-17T14:04:48-05:00","country_code":"US","country_name":"United States","province_code":"NC","legacy":false,"active":true},{"id":50471927968,"name":"Clarksville","address1":"951 East Lewis and Clark Parkway","address2":"","city":"Clarksville","zip":"47129","province":"IN","country":"US","phone":"+18122843112","created_at":"2020-07-17T14:29:08-05:00","updated_at":"2020-07-17T14:29:09-05:00","country_code":"US","country_name":"United States","province_code":"IN","legacy":false,"active":true},{"id":50466848928,"name":"Columbus","address1":"2200 Morse Road","address2":"","city":"Columbus","zip":"43229","province":"OH","country":"US","phone":"+16143371258","created_at":"2020-07-17T13:15:11-05:00","updated_at":"2020-07-17T13:15:12-05:00","country_code":"US","country_name":"United States","province_code":"OH","legacy":false,"active":true},{"id":50472714400,"name":"Daytona","address1":"1300 West International Speedway Boulevard","address2":"","city":"Daytona Beach","zip":"32114","province":"FL","country":"US","phone":"+13869443938","created_at":"2020-07-17T14:36:50-05:00","updated_at":"2020-07-17T14:36:50-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50467537056,"name":"Destin","address1":"761 U.S. 98","address2":"","city":"Destin","zip":"32541","province":"FL","country":"US","phone":"+18506503401","created_at":"2020-07-17T13:22:14-05:00","updated_at":"2020-07-17T13:22:15-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50470453408,"name":"Fairview Heights","address1":"10785 Lincoln Trail","address2":"","city":"Fairview Heights","zip":"62208","province":"IL","country":"US","phone":"+16183980165","created_at":"2020-07-17T14:08:48-05:00","updated_at":"2020-07-17T14:08:49-05:00","country_code":"US","country_name":"United States","province_code":"IL","legacy":false,"active":true},{"id":50467471520,"name":"Florissant","address1":"42 Grandview Plaza Shopping Center","address2":"","city":"Florissant","zip":"63033","province":"MO","country":"US","phone":"+13148319949","created_at":"2020-07-17T13:21:20-05:00","updated_at":"2020-07-17T13:21:21-05:00","country_code":"US","country_name":"United States","province_code":"MO","legacy":false,"active":true},{"id":50466816160,"name":"Foley","address1":"7976 Alabama 59","address2":"","city":"Foley","zip":"36535","province":"AL","country":"US","phone":"+12519555240","created_at":"2020-07-17T13:14:29-05:00","updated_at":"2020-07-17T13:14:30-05:00","country_code":"US","country_name":"United States","province_code":"AL","legacy":false,"active":true},{"id":50467274912,"name":"Forest Park","address1":"1191 Smiley Avenue","address2":"","city":"Cincinnati","zip":"45240","province":"OH","country":"US","phone":"+15138255211","created_at":"2020-07-17T13:18:31-05:00","updated_at":"2020-07-17T13:18:32-05:00","country_code":"US","country_name":"United States","province_code":"OH","legacy":false,"active":true},{"id":50467078304,"name":"Fort Myers","address1":"4450 Fowler Street","address2":"","city":"Fort Myers","zip":"33901","province":"FL","country":"US","phone":"+12392781141","created_at":"2020-07-17T13:17:20-05:00","updated_at":"2020-07-17T13:17:21-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50469798048,"name":"Greenville","address1":"2425 Laurens Road","address2":"","city":"Greenville","zip":"29607","province":"SC","country":"US","phone":"+18642549263","created_at":"2020-07-17T14:03:29-05:00","updated_at":"2020-07-17T14:03:30-05:00","country_code":"US","country_name":"United States","province_code":"SC","legacy":false,"active":true},{"id":50471862432,"name":"Huntsville","address1":"9076 Madison Boulevard","address2":"","city":"Madison","zip":"35758","province":"AL","country":"US","phone":"+12567727272","created_at":"2020-07-17T14:28:11-05:00","updated_at":"2020-07-17T14:28:11-05:00","country_code":"US","country_name":"United States","province_code":"AL","legacy":false,"active":true},{"id":50468028576,"name":"Indianapolis","address1":"8811 Hardegan Street","address2":"","city":"Indianapolis","zip":"46227","province":"IN","country":"US","phone":"+13178881810","created_at":"2020-07-17T13:33:49-05:00","updated_at":"2020-07-17T13:33:49-05:00","country_code":"US","country_name":"United States","province_code":"IN","legacy":false,"active":true},{"id":50468290720,"name":"Kansas City","address1":"14221 East US Highway 40","address2":"#8","city":"Kansas City","zip":"64136","province":"MO","country":"US","phone":"+18163507775","created_at":"2020-07-17T13:38:05-05:00","updated_at":"2020-07-17T13:38:06-05:00","country_code":"US","country_name":"United States","province_code":"MO","legacy":false,"active":true},{"id":50472812704,"name":"Kenneth City","address1":"4665 66th Street North","address2":"","city":"Kenneth City","zip":"33709","province":"FL","country":"US","phone":"+17273100095","created_at":"2020-07-17T14:38:01-05:00","updated_at":"2020-07-17T14:38:01-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50472386720,"name":"Knoxville","address1":"267 North Seven Oaks Drive","address2":"","city":"Knoxville","zip":"37922","province":"TN","country":"US","phone":"+18658628872","created_at":"2020-07-17T14:33:08-05:00","updated_at":"2020-07-17T14:33:08-05:00","country_code":"US","country_name":"United States","province_code":"TN","legacy":false,"active":true},{"id":50473009312,"name":"Largo","address1":"1121 Missouri Avenue North","address2":"","city":"Largo","zip":"33770","province":"FL","country":"US","phone":"+17273511366","created_at":"2020-07-17T14:38:50-05:00","updated_at":"2020-07-17T14:38:50-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50466193568,"name":"Madison","address1":"111 Gallatin Pike North","address2":"","city":"Nashville","zip":"37115","province":"TN","country":"US","phone":"+16158654500","created_at":"2020-07-17T13:04:35-05:00","updated_at":"2020-07-17T13:04:35-05:00","country_code":"US","country_name":"United States","province_code":"TN","legacy":false,"active":true},{"id":50466750624,"name":"Marietta","address1":"2949 Canton Road","address2":"Suite 100","city":"Marietta","zip":"30066","province":"GA","country":"US","phone":"+17704199360","created_at":"2020-07-17T13:13:29-05:00","updated_at":"2020-07-17T13:13:30-05:00","country_code":"US","country_name":"United States","province_code":"GA","legacy":false,"active":true},{"id":50471731360,"name":"Melbourne","address1":"1270 North Wickham Road","address2":"","city":"Melbourne","zip":"32935","province":"FL","country":"US","phone":"+13217573600","created_at":"2020-07-17T14:27:29-05:00","updated_at":"2020-07-17T14:27:30-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50471076000,"name":"Merrillville","address1":"8225 Broadway","address2":"","city":"Merrillville","zip":"46410","province":"IN","country":"US","phone":"+12197939725","created_at":"2020-07-17T14:22:01-05:00","updated_at":"2020-07-17T14:22:02-05:00","country_code":"US","country_name":"United States","province_code":"IN","legacy":false,"active":true},{"id":50466455712,"name":"Mobile","address1":"4001 Government Boulevard","address2":"","city":"Mobile","zip":"36693","province":"AL","country":"US","phone":"+12516662122","created_at":"2020-07-17T13:07:53-05:00","updated_at":"2020-07-17T13:07:53-05:00","country_code":"US","country_name":"United States","province_code":"AL","legacy":false,"active":true},{"id":36217290797,"name":"Murfreesboro","address1":"480 River Rock Boulevard","address2":"","city":"Murfreesboro","zip":"37128","province":"TN","country":"US","phone":"+16158906060","created_at":"2019-12-18T14:08:47-06:00","updated_at":"2020-07-17T13:02:58-05:00","country_code":"US","country_name":"United States","province_code":"TN","legacy":false,"active":true},{"id":50472124576,"name":"New Port Richey","address1":"5217 U.S. 19","address2":"","city":"New Port Richey","zip":"34652","province":"FL","country":"US","phone":"+17272328550","created_at":"2020-07-17T14:31:16-05:00","updated_at":"2020-07-17T14:31:17-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50470224032,"name":"Ocoee","address1":"11029 West Colonial Drive","address2":"","city":"Ocoee","zip":"34761","province":"FL","country":"US","phone":"+14078770412","created_at":"2020-07-17T14:06:16-05:00","updated_at":"2020-07-17T14:06:17-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50472419488,"name":"Orange Park","address1":"380 Blanding Boulevard","address2":"","city":"Orange Park","zip":"32073","province":"FL","country":"US","phone":"+19045924622","created_at":"2020-07-17T14:33:42-05:00","updated_at":"2020-07-17T14:33:43-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50466881696,"name":"Parma Heights","address1":"7011 West 130th Street","address2":"","city":"Parma Heights","zip":"44130","province":"OH","country":"US","phone":"+14408421244","created_at":"2020-07-17T13:15:59-05:00","updated_at":"2020-07-17T13:15:59-05:00","country_code":"US","country_name":"United States","province_code":"OH","legacy":false,"active":true},{"id":50469601440,"name":"Pelham","address1":"3001 Pelham Parkway","address2":"","city":"Pelham","zip":"35124","province":"AL","country":"US","phone":"+12056634700","created_at":"2020-07-17T14:00:07-05:00","updated_at":"2020-07-17T14:00:07-05:00","country_code":"US","country_name":"United States","province_code":"AL","legacy":false,"active":true},{"id":50472648864,"name":"Pensacola","address1":"5065 North 9th Avenue","address2":"","city":"Pensacola","zip":"32504","province":"FL","country":"US","phone":"+18504541177","created_at":"2020-07-17T14:36:18-05:00","updated_at":"2020-07-17T14:36:19-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50471993504,"name":"Pigeon Forge","address1":"2735 Teaster Lane","address2":"","city":"Pigeon Forge","zip":"37863","province":"TN","country":"US","phone":"+18654536882","created_at":"2020-07-17T14:30:15-05:00","updated_at":"2020-07-17T14:30:16-05:00","country_code":"US","country_name":"United States","province_code":"TN","legacy":false,"active":true},{"id":50472583328,"name":"Stuart","address1":"3020 SE Federal Hwy","address2":"","city":"","zip":"","province":"AL","country":"US","phone":"+17726787863","created_at":"2020-07-17T14:35:13-05:00","updated_at":"2020-07-17T14:35:13-05:00","country_code":"US","country_name":"United States","province_code":"AL","legacy":false,"active":true},{"id":50470977696,"name":"Surfside Beach","address1":"1870 North Kings Highway","address2":"","city":"North Myrtle Beach","zip":"29582","province":"SC","country":"US","phone":"+18432380919","created_at":"2020-07-17T14:21:03-05:00","updated_at":"2020-07-17T14:40:42-05:00","country_code":"US","country_name":"United States","province_code":"SC","legacy":false,"active":true},{"id":50466947232,"name":"Tamarac","address1":"4021 West Commercial Boulevard","address2":"","city":"Tamarac","zip":"33319","province":"FL","country":"US","phone":"+19544864883","created_at":"2020-07-17T13:16:37-05:00","updated_at":"2020-07-17T13:16:37-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50469372064,"name":"Tampa","address1":"10087 East Adamo Drive","address2":"#50","city":"Tampa","zip":"33619","province":"FL","country":"US","phone":"+18136278448","created_at":"2020-07-17T13:55:40-05:00","updated_at":"2020-07-17T13:55:41-05:00","country_code":"US","country_name":"United States","province_code":"FL","legacy":false,"active":true},{"id":50472321184,"name":"Tulsa","address1":"8939 South Memorial Drive","address2":"","city":"Tulsa","zip":"74133","province":"OK","country":"US","phone":"+19185050030","created_at":"2020-07-17T14:32:28-05:00","updated_at":"2020-07-17T14:32:28-05:00","country_code":"US","country_name":"United States","province_code":"OK","legacy":false,"active":true},{"id":50472222880,"name":"West Chicago","address1":"1935 North Neltnor Boulevard","address2":"","city":"West Chicago","zip":"60185","province":"IL","country":"US","phone":"+16309575512","created_at":"2020-07-17T14:31:53-05:00","updated_at":"2020-07-17T14:31:54-05:00","country_code":"US","country_name":"United States","province_code":"IL","legacy":false,"active":true},{"id":50470813856,"name":"Wilmington","address1":"4302 Shipyard Boulevard","address2":"","city":"Wilmington","zip":"28403","province":"NC","country":"US","phone":"+19107849733","created_at":"2020-07-17T14:18:44-05:00","updated_at":"2020-07-17T14:18:45-05:00","country_code":"US","country_name":"United States","province_code":"NC","legacy":false,"active":true}]}';

    $locations=json_decode($json);

    $newArray=[];
    foreach ($locations->locations as $loc) {
      $newArray[$loc->name]=$loc;
    }


    $data = [
      "Bonita Springs"=>8,
      "Casselberry"=>3,
      "Charlotte"=>1,
      "Columbus"=>6,
      "Daytona"=>16,
      "Florissant"=>15,
      "Foley"=>15,
      "Forest Park"=>7,
      "Fort Myers"=>9,
      "Greenville"=>1,
      "Indianapolis"=>1,
      "Kansas City"=>16,
      "Kenneth City"=>13,
      "Knoxville"=>10,
      "Largo"=>10,
      "Madison"=>7,
      "Marietta"=>20,
      "Melbourne"=>8,
      "Merrillville"=>1,
      "Mobile"=>17,
      "Murfreesboro"=>12,
      "New Port Richey"=>28,
      "Ocoee"=>8,
      "Orange Park"=>18,
      "Pelham"=>1,
      "Pensacola"=>5,
      "Pigeon Forge"=>72,
      "Stuart"=>16,
      "Tamarac"=>12,
      "Tampa"=>13,
      "West Chicago"=>2,
      "Wilmington"=>1,
    ];
      DB::table('tbl_inventory')->where(['shopify_product_id'=>$product_id])->delete();
    $saveArray=[];
    foreach ($data as $lc_name => $qty) {
      if(isset($newArray[$lc_name])){
        $locationData = $newArray[$lc_name];
        $saveArray[]=[
          'inventory_item_id'=>$item_id,
          'location_id'=>$locationData->id,
          'shopify_product_id'=>$product_id,
          'shopify_variant_id'=>$variant_id,
          'available_qty'=>$qty
        ];
      }
    }
    DB::table('tbl_inventory')->insert($saveArray);

    echo "<pre>";
    print_r($saveArray);
    echo "</pre>";

    echo $variant_id."--".$product_id."--".$item_id;

    exit;

  }


  public function CheckProduct(Request $request)
  {
   $shop = $request->shop;
   $settings=Settings::where('shop',$shop)->first();
   $ShopifyApiClient = User::where('name',$shop)->first();
   if($settings){
     date_default_timezone_set($settings->timezone);
   }
   $product = $request->product;
   $product_id = $product['id'];
   $return = [];
   foreach ($product['variants'] as $key => $variant) {
     $variant_id =  $variant['id'];
     $locations = DB::table('tbl_inventory')->where(['shop_id' =>$ShopifyApiClient->id,'shopify_product_id'=>$product_id,'shopify_variant_id'=>$variant_id])->where('available_qty', '>',0)->get();
     $isAvaible=false;
     foreach ($locations as $location){
           $ldetails = DB::table('locations')->where(['shopify_location_id'=>$location->location_id,'shop'=>$shop,'super_admin_status'=>1])->first();
           $isOpen = false;
             if(isset($ldetails->store_hours)){
                 switch ($ldetails->store_hours){
                   case 'automatic':
                     $currentDay = lcfirst(Carbon::now()->format('l'));
                     $timings = DB::table('store_timing')->select('open_time','close_time')->where(['days_name' => $currentDay,'location_id'=>$location->location_id,'shop'=>$shop])->first();
                       if($timings){
                         $isOpen = Carbon::now()->between(Carbon::parse($timings->open_time),Carbon::parse($timings->close_time));
                       }
                   break;
                   case 'menual':
                   if($ldetails->is_open == 1){
                     $isOpen = true;
                   }
                   break;
                 }
             }
           if($isOpen){
             $isAvaible = true;
             break;
           }
     }
     $return[$variant_id] = ['is_available'=>$isAvaible];
   }
   return response()->json($return);
  }

  public function checklocation(Request $request){
        $shop = $request->shop;
        $settings=Settings::where('shop',$shop)->first();
        $ShopifyApiClient = User::where('name',$shop)->first();
        if($settings){
          date_default_timezone_set($settings->timezone);
        }
        $cart = (array)$request->cart;
        $return=[];
        $allCount=0;
        foreach ($cart['items'] as $singleCart){
              $variant_id = $singleCart['variant_id'];
              $product_id = $singleCart['product_id'];
              $itemLocations =[];
              $locations = DB::table('tbl_inventory')->where(['shop_id' =>$ShopifyApiClient->id,'shopify_product_id'=>$product_id,'shopify_variant_id'=>$variant_id])->where('available_qty', '>',0)->get();
              $isAvaible=false;
              foreach ($locations as $location){
                    $ldetails = DB::table('locations')->where(['shopify_location_id'=>$location->location_id,'shop'=>$shop,'super_admin_status'=>1])->first();
                    $isOpen = false;
                    if(isset($ldetails->store_hours)){
                      switch ($ldetails->store_hours){
                        case 'automatic':
                          $currentDay = lcfirst(Carbon::now()->format('l'));
                          $timings = DB::table('store_timing')->select('open_time','close_time')->where(['days_name' => $currentDay,'location_id'=>$location->location_id,'shop'=>$shop])->first();
                            if($timings){
                              $isOpen = Carbon::now()->between(Carbon::parse($timings->open_time),Carbon::parse($timings->close_time));
                            }
                        break;
                        case 'menual':
                        if($ldetails->is_open == 1){
                          $isOpen = true;
                        }
                        break;
                      }
                    }
                if($isOpen){
                  $isAvaible = true;
                  break;
                }
              }
              if($isAvaible){
                $allCount++;
              }
          $return[$variant_id] = ['is_available'=>$isAvaible];
        }
        if(count($cart['items']) == $allCount){
          return response()->json(['code'=>200,'msg'=>'All Items Are Availbale']);
        }else{
          return response()->json(['code'=>100,'msg'=>'All Item Stocks Not avilable']);
        }
  }

}
