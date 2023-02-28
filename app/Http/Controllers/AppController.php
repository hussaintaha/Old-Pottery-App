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
use URL;
class AppController extends Controller
{



  public function super_admin_dashboard(Request $request)
  {
    $shop = $request->shop;
    $ShopifyApiClient =User::where('name',$request->shop)->first();
    // $shopdetails = $ShopifyApiClient->api()->request('GET', '/admin/api/'.getYear().'/webhooks.json');
    $shopdetails = $ShopifyApiClient->api()->request('GET', '/admin/api/'.getYear().'/shop.json');
    // dd($shopdetails);
    $orders = DB::table('location_orders')
              ->select('location_orders.*','locations.location_name')
              ->join('locations','location_orders.shopify_location_id','=','locations.shopify_location_id')
              ->where(['location_orders.shop' => $request->shop])
              ->get();
      $new_orders=[];
      $settings = Settings::where('shop',$shop)->first();
      if($settings){
        date_default_timezone_set($settings->timezone);
      }
      $distinctOrders = DB::table('location_orders')->select('order_number','status')->distinct()->where(['shop' => $shop])->get();
      $checkArray=[];
      foreach ($distinctOrders as $ord) {
        $checkArray[$ord->order_number]=$ord;
      }
      $returnArray=[];
      foreach ($orders as  $order){
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
      foreach ($orders as  $order) {
        if(!isset($new_orders['pending'])){
          $new_orders['pending'] = [];
        }
        if(!isset($new_orders['processing'])){
          $new_orders['processing'] = [];
        }
        if(!isset($new_orders['delivered'])){
          $new_orders['delivered'] = [];
        }
        if($order->status == 0){
          $new_orders['pending'][]=$order;
        }
        if($order->status == 1){
          $new_orders['processing'][]=$order;
        }
        if($order->status == 2){
          $new_orders['delivered'][]=$order;
        }
      }
      // dd($returnArray);
      $swicth = DB::table('locations')
                      ->select('super_admin_status')
                      ->distinct()
                      ->where(['shop' => $request->shop])
                      ->first();
      $locations = DB::table('locations')
                      ->where(['shop' => $request->shop])
                      ->get();
        $adminData = [
          'appURL'=>URL::to('/'),
          'shop'=>$request->shop,
          'page'=>'dashboard',
          'orders'=>$returnArray,
          'locations'=>$locations,
          'new_orders'=>$new_orders,
          'currency'=>$shopdetails['body']['container']['shop']['currency']
        ];
        if(isset($swicth->super_admin_status)){
            $adminData['switch'] = $swicth->super_admin_status;
        }
    return View::make('superadmin.dashboard',$adminData);
  }

  public function PosPrint(Request $request)
  {

      $id = $request->order_id;
      $shop =$request->shop;
      $ShopifyApiClient =User::where('name',$shop)->first();
      $det = DB::table('location_orders')->where(['id'=>$id])->first();
      $orders = DB::table('location_orders')->where(['order_number'=>$det->order_number,'shopify_location_id'=>$det->shopify_location_id])->pluck('Shopify_variant_id')->toArray();
      $order = $ShopifyApiClient->api()->request('GET','/admin/api/'.getYear().'/orders/'.$det->order_number.'.json');
      $shopdetails = $ShopifyApiClient->api()->request('GET','/admin/api/'.getYear().'/shop.json');
      $items=[];
      foreach ($order['body']['container']['order']['line_items'] as $line) {
        if(in_array($line['variant_id'],$orders)){
          $items[]=$line;
        }
      }

      return View::make('superadmin.posinvoice',[
        'shop_name'=>$shopdetails['body']['container']['shop']['name'],
        'page'=>'a_orders',
        'order'=>$det,
        'items'=>$items,
        'currency'=>$order['body']['container']['order']['currency']
      ]);
  }

  public function OrderListByLocation(Request $request)
  {
    $shop = $request->shop;
    $where=[];
    $where['location_orders.shop'] = $request->shop;
    $orders = DB::table('location_orders')
              ->select('location_orders.*','locations.location_name')
              ->join('locations','location_orders.shopify_location_id','=','locations.shopify_location_id')
              ->where($where)
              ->get();
    $return=[];
    foreach ($orders as  $order) {
      if($order->status == 0){
        $return['pending'][]=$order;
      }
      if($order->status == 1){
        $return['processing'][]=$order;
        $processing[]=$order;
      }
      if($order->status == 2){
        $return['delivered'][]=$order;
        $delivered[]=$order;
      }
    }



  }

  public function CloseOpenAllLocations(Request $request)
  {
    $update = DB::table('locations')->where(['shop' => $request->shop])->update(['super_admin_status'=>$request->status]);
    if($update){
      echo json_encode(['code'=>200,'msg'=>"Status Changed"]);
    }else{
      echo json_encode(['code'=>100,'msg'=>"Someting went wrong Please Try after Sometime"]);
    }
  }



  public function super_admin_settings(Request $request)
  {
    $shop=  $request->shop;
    $ShopifyApiClient =User::where('name',$request->shop)->first();
    $shop_data        = (object)$ShopifyApiClient->api()->request('GET', '/admin/api/'.getYear().'/locations/'.$request->location_id.'.json');
    $Settings=Settings::where('shop',$shop)->first();

    $timezone = DB::table('time_zones_list')->get();
    return View::make('superadmin.settings',
      ['appURL'=>URL::to('/'),'shop'=>$request->shop,'page'=>'settings','settings'=>$Settings,'timezone'=>$timezone]
    );
  }

  public function submit_settings(Request $request)
  {
  //  dd($request->all());
  $shop=  $request->shop;
    $Settings=Settings::where('shop',$shop)->first();
    if(!$Settings){
      $Settings=  new Settings;
      $Settings->shop=$shop;
      $Settings->is_store_pickup=($request->pickup=="yes") ? 1:0;
      $Settings->is_local_delivery=($request->delivery=="yes") ? 1:0;
      $Settings->google_api_key=$request->apikey;
      $Settings->timezone=$request->timezone;
      $Settings->out_of_stock_message=$request->out_of_stock_message;
      $Settings->save();
    }else{
      $Settings->shop=$shop;
      $Settings->is_store_pickup=($request->pickup=="yes") ? 1:0;
      $Settings->is_local_delivery=($request->delivery=="yes") ? 1:0;
      $Settings->google_api_key=$request->apikey;
      $Settings->out_of_stock_message=$request->out_of_stock_message;
      $Settings->timezone=$request->timezone;
      $Settings->update();
    }

    $response=['code'=>200,'msg'=>'Settings updated.'];

    return response()->json($response);
  }

  public function submit_locations(Request $request)
  {

    // dd($request->all());
    if($request->email==''){
      $response=['code'=>100,'msg'=>'Email id required!'];
      return response()->json($response);

    }

    if($request->password==''){
      $response=['code'=>100,'msg'=>'Password required!'];
      return response()->json($response);
    }

    if($request->storehrstype=="automatic"){
      if(!$request->days){
        $response=['code'=>100,'msg'=>'Please select days'];
        return response()->json($response);
      }
    }

    $newLocation=locations::where('shopify_location_id',$request->location_id)->first();

    $old_email=locations::where('email',$request->email)->first();
    $old_email_count=locations::where('email',$request->email)->count();
    if($old_email){
      if($old_email->shopify_location_id != $request->location_id){
        $response=['code'=>100,'msg'=>'Email already used in other location.'];
        return response()->json($response);
      }
    }

    if($old_email_count > 1 ){
      $response=['code'=>100,'msg'=>'Email already exists.'];
      return response()->json($response);
    }
    if(!$newLocation){
      $newLocation=new locations;
      $newLocation->shopify_location_id=$request->location_id;
      $newLocation->shop=$request->shop;
      $newLocation->location_name=$request->company_name;
      $newLocation->address=$request->address_line_1;
      $newLocation->address1=$request->address_line_2;
      $newLocation->city=$request->city;
      $newLocation->country=$request->country;
      $newLocation->state=$request->state;
      $newLocation->zip_code=$request->postal_code;
      $newLocation->store_hours=$request->storehrstype;
      $newLocation->geo_langitude=$request->longitude;
      $newLocation->geo_latitiude=$request->latitude;
      $newLocation->email=$request->email;
      $newLocation->password=$request->password;
      $newLocation->save();
    }else{
        $newLocation->shopify_location_id=$request->location_id;
        $newLocation->shop=$request->shop;
        $newLocation->location_name=$request->company_name;
        $newLocation->address=$request->address_line_1;
        $newLocation->address1=$request->address_line_2;
        $newLocation->city=$request->city;
        $newLocation->country=$request->country;
        $newLocation->state=$request->state;
        $newLocation->zip_code=$request->postal_code;
        $newLocation->store_hours=$request->storehrstype;
        $newLocation->geo_langitude=$request->longitude;
        $newLocation->geo_latitiude=$request->latitude;
        $newLocation->email=$request->email;
        $newLocation->password=$request->password;
        $newLocation->update();
    }


    if($request->storehrstype=="automatic"){
      if($request->days){
        Storetiming::where('shop',$request->shop)->where('location_id',$request->location_id)->delete();
        $open_time=$request->open_time;
        $close_time=$request->close_time;

        foreach ($request->days as $key => $value) {
          $newTime = new Storetiming;
          $newTime->shop=$request->shop;
          $newTime->location_id=$request->location_id;
          $newTime->days_name=$value;
          $newTime->open_time=$open_time[$value];
          $newTime->close_time=$close_time[$value];
          $newTime->save();
        }
      }
    }

    $response=['code'=>200,'msg'=>'Location updated.'];
    return response()->json($response);

  }

  public function super_admin_locations(Request $request){
    $ShopifyApiClient =User::where('name',$request->shop)->first();
    $shop_data        = (object)$ShopifyApiClient->api()->request('GET', '/admin/api/'.getYear().'/locations.json');
    // dd($shop_data);
    $shop = $request->shop;
    $settings = Settings::where('shop',$shop)->first();
    $apiKey = $settings->google_api_key;
    $locations=[];
    if(count($shop_data->body->locations)>0) {
      foreach ($shop_data->body->locations as $number=>$singleLocation) {
        // echo "<pre>";
        // print_r($singleLocation);
        // echo "</pre>";
        $loc = new\ stdClass();
        $loc->shopify_location=$singleLocation;
        $loc->location_info=locations::where('shopify_location_id',$singleLocation->id)->first();
        $locations[]=$loc;
      }
    }

    // echo "<pre>";
    // print_r($locations);
    // echo "</pre>";
    // exit;
    return View::make('superadmin.locations',
      ['appURL'=>URL::to('/'),'shop'=>$request->shop,'page'=>'manage-locatins','locations'=>$locations]
    );
  }

  public function edit_location_data(Request $request){
    $shop = $request->shop;
    $ShopifyApiClient =User::where('name',$shop)->first();
    $shop_data        = (object)$ShopifyApiClient->api()->request('GET', '/admin/api/'.getYear().'/locations/'.$request->location_id.'.json');
    $time_list=DB::table('time_list')->get();
    $days=Days::all();
    $shop_location=locations::where('shopify_location_id',$request->location_id)->first();
    $storeTimings = DB::table('store_timing')->where(['location_id'=>$request->location_id,'shop'=>$shop])->get();

    $timingsArray=[];
    if($storeTimings){
      foreach ($storeTimings as $tmg) {
        $timingsArray[$tmg->days_name] = $tmg;
      }
    }
  if(!$shop_location){
    $open_close_time=[];
    foreach ($days as $single_days){
        $time = new\ stdClass();
        $time->open_time='9:00';
        $time->close_time='17:00';
        $time->days_name=$single_days->days_name;
        if(isset($timingsArray[$time->days_name])){
          $time->details= $timingsArray[$time->days_name];
        }
        $time->days_title=$single_days->days_title;
        $open_close_time[$single_days->days_name]=$time;
    }
  }else{
    $open_close_time=[];
    foreach ($days as $single_days){
      $time = new\ stdClass();
      $time->open_time='9:00';
      $time->close_time='17:00';
      $time->days_name=$single_days->days_name;
      $time->days_title=$single_days->days_title;
      if(isset($timingsArray[$time->days_name])){
        $time->details= $timingsArray[$time->days_name];
      }
      $open_close_time[$single_days->days_name]=$time;
    }
  }
      $data = [
        'appURL'=>URL::to('/'),
        'shop'=>$request->shop,
        'page'=>'edit-locations',
        'shopify_location'=>$shop_data,
        'shop_timing'=>$open_close_time,
        'time_list'=>$time_list,
      ];
      if($shop_location){
        $data['location_details'] = $shop_location;
      }
      if($storeTimings){
        $data['timings'] = $storeTimings;
      }

    return View::make('superadmin.editlocation',$data);
  }






  public function shopscript(Request $request){
    $contents = View::make('shopjs')->with('openlocation', 1);
    $response = Response::make($contents, 200);
    $response->header('Content-Type', 'application/javascript');
    return $response;
  }

  private  $config='';
  public function __construct()
  {
  }
  public function customer_data_webhook(Request $request) {
    $response = file_get_contents('php://input');


    return response('OK', 200)->header('Content-Type', 'text/plain');
  }
  public function shop_data_webhook(Request $request) {
    $response = file_get_contents('php://input');
    return response('OK', 200)->header('Content-Type', 'text/plain');
  }
    //Start thankyou mail
    public function thankyouwebhook(Request $request) {
      $response = file_get_contents('php://input');
      $data = json_decode($response, true);
     $shop = $request->header('x-shopify-shop-domain');
       Log::info("Processing_webhook".json_encode($shop));
      $ShopifyApiClient = User::where('name',$shop)->first();
      $domain = $ShopifyApiClient->getDomain()->toNative();
      //dd($ShopifyApiClient);
      if($shop!=''){
        $this->configuration($shop);
        $iSAlready = Thankyou::where(['name'=>$data['name'],'shop_id'=>$ShopifyApiClient->id])->first();
      //  dd($iSAlready);
        if(!$iSAlready){
          if (isset($data['id'])) {
            // If cart token matched
            $didCartTokenMatch = Abandon::where('cart_token', $data['cart_token'])->exists();
              $notabandon=0;
            if($didCartTokenMatch) {

              $iSAlreadyConfirmed = ConfirmedAbandoned::where(['name'=>$data['name'], 'shop_id'=>$ShopifyApiClient->id])->first();
              if (!$iSAlreadyConfirmed) {
                $newConfirmedAbandoned                   = new ConfirmedAbandoned;
                $newConfirmedAbandoned->shop_id          = $ShopifyApiClient->id;
                $newConfirmedAbandoned->email            = $data['email'];
                $newConfirmedAbandoned->total_price      = $data['total_price'];
                $newConfirmedAbandoned->subtotal_price   = $data['subtotal_price'];
                $newConfirmedAbandoned->currency         = $data['currency'];
                $newConfirmedAbandoned->name             = $data['name'];
                $newConfirmedAbandoned->contact_email    = $data['contact_email'];
                $newConfirmedAbandoned->order_status_url = $data['order_status_url'];
                $newConfirmedAbandoned->customer_name    = $data['customer']['first_name'];
                $newConfirmedAbandoned->job_status       = 0;
                $newConfirmedAbandoned->mail_status      = 0;
                $notabandon=1;
                //dd($newThankyouOrder);
               $newConfirmedAbandoned->save();

                $keys = DB::table('mailwizz_keys')->where(['shop_id'=>$ShopifyApiClient->id])->first();
                $abandon_list_uid = $keys->abandon_list_uid;
              //  dd($abandon_list_uid);
                if ($abandon_list_uid) {
                  $this->delete_subscriber($shop, $data['email'], $abandon_list_uid);
                }
              }
            }

              $newThankyouOrder = new Thankyou;
              $newThankyouOrder->shop_id=$ShopifyApiClient->id;
              $newThankyouOrder->email=$data['email'];
              $newThankyouOrder->total_price=$data['total_price'];
              $newThankyouOrder->subtotal_price=$data['subtotal_price'];
              $newThankyouOrder->currency=$data['currency'];
              $newThankyouOrder->name=$data['name'];
              $newThankyouOrder->contact_email=$data['contact_email'];
              $newThankyouOrder->order_status_url=$data['order_status_url'];
              $newThankyouOrder->customer_name=$data['customer']['first_name'];
              $newThankyouOrder->job_status=0;
              $newThankyouOrder->mail_status=0;

              //dd($newThankyouOrder);
              $newThankyouOrder->save();


              $keys = DB::table('mailwizz_keys')->where(['shop_id'=>$ShopifyApiClient->id])->first();
              $thankyou_list_uid = $keys->thankyou_list_uid;
              if ($thankyou_list_uid) {
                $this->create_subscriber_thankyou($shop, $data['email'], $data['customer']['first_name'], $data['customer']['last_name'], $data['order_status_url'], $thankyou_list_uid);
              }


              Log::info("Request send to queue---");
              //$this->processOrder($data);
              Log::info("Request Cycle with Queues Begins");
            //  $this->ThankyouMail($newThankyouOrder);
            if($this->ThankyouMail($newThankyouOrder)){
              $newThankyouOrder->mail_status = 1;
              $newThankyouOrder->update();
              if($notabandon){

                $newConfirmedAbandoned->mail_status = 1;
                $newConfirmedAbandoned->update();
              }


            };
             //dispatch(new CompleteOrder($data))->delay(Carbon::now()->addSeconds(1));
              Log::info("Request Cycle with Queues Ends");
          }
        }
      }

      return response('OK', 200)->header('Content-Type', 'text/plain');
    }

    public function ThankyouMail($data) {

      // check for email feature
      $shop_data = User::where('id',$data->shop_id)->first();
      // if no email feature then return false
      if (!$shop_data->email_feature) {
        return false;
      }

      $template = $this->getThankyouTemplate($data->shop_id);
      if($template){
        $mailwizz = DB::table('mailwizz_keys')->where(['shop_id'=>$data->shop_id])->first();
        if ($mailwizz) {
          $replacedata['total_price']=$data->total_price;
          $replacedata['subtotal_price']=$data->subtotal_price;
          $replacedata['currency']=$data->subtotal_price;
          $replacedata['order_number']=$data->name;
          $replacedata['contact_email']=$data->contact_email;
          $replacedata['ORDER_STATUS_URL']=$data->order_status_url;
          $replacedata['CUSTOMER_NAME']=$data->customer_name;
          $content = $this->replacement($template->email_template,$replacedata);
          $endpoint = new MailWizzApi_Endpoint_TransactionalEmails();
          $response = $endpoint->create(array(
              'to_name'           => $data->customer_name, // required
              'to_email'          => $data->email, // required
              'from_name'         => $mailwizz->from_name, // required
              'from_email'        => $mailwizz->from_email, // optional
              'reply_to_name'     => '', // optional
              'reply_to_email'    => $mailwizz->reply_to, // optional
              'subject'           => $mailwizz->subject_for_thankyou_email, // required
              'body'              => $content, // required
              'plain_text'        => '', // optional, will be autogenerated if missing
              'send_at'           => date('Y-m-d H:i:s'),  // required, UTC date time in same format!
          ));
          $response   = $response->body;
            if ($response->itemAt('status') == 'success') {
                return true;

            }
          }
      }
    }

    public function getThankyouTemplate($shop_id)
    {
        $template=Template::where(["shop_id"=>$shop_id,'mail_type'=>1])->first();
        if($template){
          return $template;
        }
    }

  //end thankyou mail
  public function test(Request $request)
  {
    $this->delete_subscriber($request->shop, $request->email, $request->thankyou_list_uid);
    // $ShopifyApiClient = ShopifyApp::shop_get($request->shop);
    // $webhook=(new WebhookManager($ShopifyApiClient))->createWebhooks();
    // $shop_data = $ShopifyApiClient->api()->request('GET', '/admin/webhooks.json');
    // dd($shop_data);
  }

  public function checkshopifyabandonCart(Request $request){
    $shoplist = User::all();

    //dd($ShopifyApiClient);
    foreach ($shoplist as $sigleShop) {
      if($sigleShop->password){
        $this->getShopifyAbandonCart($sigleShop->name);
      }

    }
  }

  public function AbandonCartEmail(Request $request) {
  Log::info("AbandonCartEmail".json_encode($request->all()));
    //dd($request->all())
    $ShopifyApiClient=$shopdata = User::where('id',$request->shop)->first();
  //  $domain = $ShopifyApiClient->getDomain()->toNative();
    // check for email feature
    $email_feature = $shopdata['email_feature'];
    // if no email feature then return back
    if (!$email_feature) {
      return;
    }

    $shop      = $shopdata->name;
    $abandonId = $request->id;
    // $abandonData=Abandon::find($abandonId)->first();
    $abandonData = Abandon::where('id', $abandonId)->first();

    $templ=Template::where(['shop_id'=>$ShopifyApiClient->id,'mail_type'=>2])->first();
  //  dd($templ);
    if($templ){
      $mailwizz = DB::table('mailwizz_keys')->where(['shop_id'=>$ShopifyApiClient->id])->first();
      if ($mailwizz) {
        $templ->email_template;
        $replacedata['CUSTOMER_NAME']          = $abandonData->customer_name;
        $replacedata['ABANDONED_CHECKOUT_URL'] = $abandonData->abandoned_checkout_url;

        $content = $this->replacement($templ->email_template,$replacedata);
        $this->configuration($shop);
        $endpoint = new MailWizzApi_Endpoint_TransactionalEmails();
        $response = $endpoint->create(array(
            'to_name'           => $abandonData->customer_name, // required
            'to_email'          => $abandonData->email, // required
            'from_name'         => $mailwizz->from_name, // required
            'from_email'        => $mailwizz->from_email, // optional
            'reply_to_name'     => '', // optional
            'reply_to_email'    => $mailwizz->reply_to, // optional
            'subject'           => $mailwizz->subject_for_abandon_cart_email, // required
            'body'              => $content, // required
            'plain_text'        => '', // optional, will be autogenerated if missing
            'send_at'           => date('Y-m-d H:i:s'),  // required, UTC date time in same format!
        ));
        // dd($response);
          Log::info("AbandonCartEmail response".json_encode($response));
        return response()->json($response);
      }
    }
    //exit;
  }


    public function replacement($string, array $placeholders) {
      //dd($placeholders);
      $resultString = $string;
      foreach($placeholders as $key => $value) {
          $resultString = str_replace('[' . $key . ']' , trim($value), $resultString, $i);
      }
      return $resultString;
    }

    public function register() {
        $data = Input::all();
        //... Dont forget about validation
        //loading template from database example
        $template = Template::where('name', 'register.success')->firstOrFail();
        $content = $this->replacement($template['text'], $data);
        View::make('register.success', ['content' => $content]); //or send mail with $content as you want
    }

  public function configuration($shop) {
    //dd($shop);

//     DB::table('mailwizz_keys')->where(['shop_id'=>$ShopifyApiClient->id])->update(['public_key'=>$request->public_key,'private_key'=>$request->public_key]);
// }else{
//     DB::table('mailwizz_keys')->insert(['shop_id'=>$ShopifyApiClient->id,'public_key'=>$request->public_key,'private_key'=>$request->public_key]);

    // $shop = $shop;
    // $ShopifyApiClient = ShopifyApp::shop_get($shop);
    // $count = DB::table('mailwizz_keys')->where(['shop_id'=>$ShopifyApiClient->id])->first();
    // if($count){
    //   $config = new MailWizzApi_Config(array(
    //       'apiUrl'        => 'http://mail.gwebseo.com/api/index.php',
    //       'publicKey'     => $count->public_key,// 'b7e7d6426b3d311f0a75ae6f1aaf7c08d7c0d1e0',
    //       'privateKey'    => $count->private_key,//'9f01932f571613feb58c532788ca64cecce328c4',
    //       // components
    //       'components' => array(
    //           'cache' => array(
    //               'class'     => 'MailWizzApi_Cache_File',
    //               'filesPath' => dirname(__FILE__) . '/../MailWizzApi/Cache/data/cache', // make sure it is writable by webserver
    //           )
    //       ),
    //   ));
    //   MailWizzApi_Base::setConfig($config);
    // }
    $ShopifyApiClient = User::where('name',$shop)->first();

    $domain = $ShopifyApiClient->getDomain()->toNative();

    $count = DB::table('mailwizz_keys')->where(['shop_id'=>$ShopifyApiClient->id])->first();

    if($count){
      $config = new MailWizzApi_Config(array(
          'apiUrl'        => $count->api_url.'/api/index.php',
          'publicKey'     => $count->public_key,// 'b7e7d6426b3d311f0a75ae6f1aaf7c08d7c0d1e0',
          'privateKey'    => $count->private_key,//'9f01932f571613feb58c532788ca64cecce328c4',
          // components
          'components' => array(
              'cache' => array(
                  'class'     => 'MailWizzApi_Cache_File',
                  'filesPath' => dirname(__FILE__) . '/../MailWizzApi/Cache/data/cache', // make sure it is writable by webserver
              )
          ),
      ));
      MailWizzApi_Base::setConfig($config);
    }
  }


  public function addtaskforShopify(Request $request) {

    // $ShopifyApiClient = ShopifyApp::shop($shop);
    // $shop_data        = $ShopifyApiClient->api()->request('GET', 'admin/shop.json');
    // $ShopDetails = $shop_data->body->shop;
    // return View::make('admin.dashboard',['appURL'=>URL::to('/'),'shop'=>$shop,'page'=>'dashboard','details'=>$ShopDetails]);
  }

  public function getShopifyAbandonCart($shop) {
  //  $shop="circlytest.myshopify.com";
    $ShopifyApiClient =User::where('name',$shop)->first();;
    //dd($ShopifyApiClient);
    $shop_data        = (object)$ShopifyApiClient->api()->request('GET', '/admin/checkouts.json');

    if(count($shop_data->body->checkouts)>0) {

      foreach ($shop_data->body->checkouts as $singleCheckOut) {
          // dd($shop_data->body->checkouts);
        $this->SaveAbandonedcheckouts($singleCheckOut, $shop);
      }
    }
  }

  public function SaveAbandonedcheckouts($apidata, $shop) {
  //  dd($apidata);
    $isold = Abandon::where('token',$apidata->token)->first();
    if(!$isold) {
        $Abandon= new Abandon;
        $Abandon->token=$apidata->token;
        $Abandon->cart_token=$apidata->cart_token;
        $Abandon->email=$apidata->email;
        $Abandon->currency=$apidata->currency;
        $Abandon->abandoned_checkout_url=$apidata->abandoned_checkout_url;
        $Abandon->total_price=$apidata->total_price;
        $Abandon->abandon_time=$apidata->created_at;
        $Abandon->customer_name=$apidata->customer->first_name;
        $Abandon->shop_id=$this->getShopid($shop);
        $Abandon->save();

        $keys = DB::table('mailwizz_keys')->where(['shop_id'=>$this->getShopid($shop)])->first();
        $abandon_list_uid = $keys->abandon_list_uid;
        if ($abandon_list_uid) {
          $this->create_subscriber_abandon($shop, $apidata->email, $apidata->customer->first_name, $apidata->customer->last_name, $apidata->abandoned_checkout_url, $abandon_list_uid);
        }

        dispatch(new AbandonMail($Abandon))->delay(Carbon::now()->addSeconds(15));
        $Abandon->job_status=1;
        $Abandon->update();
    }
  }

  public function getShopid($shop) {
    $shopdata=User::where('name',$shop)->first();
    return $shopdata->id;
  }

  public function updatelistform(Request $request) {
    $shop = $request->shop;
    $this->configuration($shop);
    $ShopifyApiClient = User::where('name',$shop)->first();
    $shop_data        = (object)$ShopifyApiClient->api()->request('GET', 'admin/shop.json');
    $shopify_shop=$shop_data->body->shop;
      //dd($shopify_shop);
    $endpoint = new MailWizzApi_Endpoint_Lists();
    $response = $endpoint->create(array(
        // required
        'general' => array(
            'name'          => 'Abandon Cart', // required
            'description'   => 'Abandon cart email list, created from the API.', // required
        ),
        // required
        'defaults' => array(
            'from_name' => $request->from_name, // required
            'from_email'=> $request->from_email, // required
            'reply_to'  => $request->reply_to, // required
            'subject'   => '',
        ),
        'company' => array(
            'name'      => $shopify_shop->name, // required
            'country'   => $shopify_shop->country_name, // required
            'zone'      =>  $shopify_shop->city, // required
            'address_1' => $shopify_shop->city, // required
            'address_2' => '',
            'zone_name' => '', // when country doesn't have required zone.
            'city'      => 'New York City',
            'zip_code'  => $shopify_shop->zip,
        ),
    ));

    dd($response->body);
  }

  public function testmailwizz($shop){
    $this->configuration($shop);
    $endpoint = new MailWizzApi_Endpoint_Lists();
    /*===================================================================================*/
    // GET ALL ITEMS
    $response = $endpoint->getLists($pageNumber = 1, $perPage = 10);
    dd($response->body);
    if(isset($response->body->status)){

    }
  }

  public function create_subscriber_abandon($shop, $email, $first_name, $last_name, $url, $uid) {
    $this->configuration($shop);
    $endpoint = new MailWizzApi_Endpoint_ListSubscribers();
    $response = $endpoint->create($uid, array(
      'EMAIL'                   => $email,
      'FNAME'                   => $first_name,
      'LNAME'                   => $last_name,
      'CUSTOMER_NAME'           => $first_name,
      'ABANDONED_CHECKOUT_URL'  => $url,
    ));
  }

  public function create_subscriber_thankyou($shop, $email, $first_name, $last_name, $url, $uid) {
    $this->configuration($shop);
    $endpoint = new MailWizzApi_Endpoint_ListSubscribers();
    $response = $endpoint->create($uid, array(
      'EMAIL'            => $email,
      'FNAME'            => $first_name,
      'LNAME'            => $last_name,
      'CUSTOMER_NAME'    => $first_name,
      'ORDER_STATUS_URL' => $url,
    ));
  }

  public function delete_subscriber($shop, $email, $uid) {
    $this->configuration($shop);
    $endpoint = new MailWizzApi_Endpoint_ListSubscribers();

    $response = $endpoint->deleteByEmail($uid, $email);

    // DISPLAY RESPONSE
    // echo '<hr /><pre>';
    // print_r($response->body);
    // echo '</pre>';
  }

  public function Dashboard(Request $request)
  {
    // dd($request->all());

  }

  public function AcceptOrder(Request $request)
  {
    $line = $request->line;
    $det = DB::table('location_orders')->where(['id'=>$line])->first();
    $shop = $request->shop;
    $shopify_location_id = $det->shopify_location_id;
    $settings = Settings::where('shop',$shop)->first();
    if($settings){
      date_default_timezone_set($settings->timezone);
    }
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

  public function UpdateOrderStatus(Request $request)
  {
      $line = $request->id;
      $det = DB::table('location_orders')->where(['id'=>$line])->first();
      $shop = $request->shop;
      $shopify_location_id = $det->shopify_location_id;
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

  public function TestGitVersioning(Request $request)
  {
    // code...
  }


}
