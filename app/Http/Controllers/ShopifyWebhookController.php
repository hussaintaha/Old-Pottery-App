<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use URL;
use App\User;
use App\locations;

class ShopifyWebhookController extends Controller
{



    public function AppUnInstalled(Request $request)
    {
      $response = file_get_contents('php://input');
      $data = json_decode($response, true);
      $shop = $request->header('x-shopify-shop-domain');
      http_response_code(200);
    }

    public function LocationAttachedToProduct(Request $request)
    {
      $response = file_get_contents('php://input');
      $variant = json_decode($response);
      $shop = $request->header('x-shopify-shop-domain');
      $ShopifyApiClient = User::where('name',$shop)->first();
      DB::table('webhooks')->insert(['event' => 'inventory-level-connected','data'=>$response,'shop_id'=>$shop]);
      http_response_code(200);
    }


    public function LocationDetachedToProduct(Request $request)
    {
      $response = file_get_contents('php://input');
      $data = json_decode($response, true);
      $shop = $request->header('x-shopify-shop-domain');
      DB::table('webhooks')->insert(['event' => 'inventory-level-disconnected','data'=>$response,'shop_id'=>$shop]);
      http_response_code(200);
    }


    public function UpdateInventoryLevel(Request $request)
    {
      $response = file_get_contents('php://input');
      $variant = json_decode($response);
      $shop = $request->header('x-shopify-shop-domain');
      $ShopifyApiClient = User::where('name',$shop)->first();
      $saveArray=['location_id' => $variant->location_id,'available_qty' => $variant->available,];
      DB::table('tbl_inventory')->where([
        'location_id'=>$variant->location_id,
        'inventory_item_id' => $variant->inventory_item_id,
        'shop' => $shop,
      ])->update($saveArray);

      DB::table('webhooks')->insert(['event' => 'inventory-level-update','data'=>$response,'shop_id'=>$shop]);
      http_response_code(200);
    }

    public function InventoryItemCreated(Request $request)
    {
      $response = file_get_contents('php://input');
      $data = json_decode($response);
      $shop = $request->header('x-shopify-shop-domain');
      $ShopifyApiClient = User::where('name',$shop)->first();
      DB::table('webhooks')->insert(['event' => 'inventory-item-create','shop_id'=>$shop,'data'=>$response,]);
      http_response_code(200);
    }

    public function InventoryItemUpdated(Request $request)
    {
      $response = file_get_contents('php://input');
      $data = json_decode($response, true);
      $shop = $request->header('x-shopify-shop-domain');
      $ShopifyApiClient = User::where('name',$shop)->first();
      DB::table('webhooks')->insert(['event' => 'inventory-item-update','shop_id'=>$shop,'data'=>$response,]);
      http_response_code(200);
    }

    public function InventoryItemDeleted(Request $request)
    {
      $response = file_get_contents('php://input');
      $data = json_decode($response);
      $shop = $request->header('x-shopify-shop-domain');
      DB::table('webhooks')->insert(['event' => 'inventory-item-delete','shop_id'=>$shop,'data'=>$response,]);
      http_response_code(200);
    }

    public function OrderCreated(Request $request)
    {
      $response = file_get_contents('php://input');
      $data = json_decode($response);
      $shop = $request->header('x-shopify-shop-domain');
      DB::table('webhooks')->insert(['event' => 'order-created','shop_id'=>$shop,'data'=>$response,]);
      http_response_code(200);
    }

    public function ProductCreated(Request $request)
    {
      $response = file_get_contents('php://input');
      $data = json_decode($response);
      $shop = $request->header('x-shopify-shop-domain');
      $ShopifyApiClient = User::where('name',$shop)->first();

      $locations = DB::table('locations')->where([
        'shop'=>$shop
        ])->get();
      Log::info('Product Created ID '.$data->id);
      if(isset($data->variants)){
      foreach ($data->variants as $key => $variant){
        foreach ($locations as $loc) {
          $users_count = DB::table('tbl_inventory')->where([
            'inventory_item_id'=>$variant->inventory_item_id,
            'shop' => $shop,
            'location_id'=>$loc->shopify_location_id,
            ])->count();

            if($users_count == 0){
              Log::info('Save Variant in Tabel Inventory Item Id '.$variant->inventory_item_id." Variant Id -".$variant->id." Location Id-".$loc->shopify_location_id);
              $saveArray=[
                'location_id'=>$loc->shopify_location_id,
                'inventory_item_id' => $variant->inventory_item_id,
                'shopify_product_id' => $variant->product_id,
                'shopify_variant_id' => $variant->id,
                'shop' => $shop,
                'event' =>'product-created'
              ];
              DB::table('tbl_inventory')->insert($saveArray);
            }else{
              $saveArray=[
                'shopify_product_id' => $variant->product_id,
                'shopify_variant_id' => $variant->id,
                'event' =>'product-updated-with-creation'
              ];
              Log::info('Update  in Tabel Inventory Item Id '.$variant->inventory_item_id." Variant Id -".$variant->id." Location Id-".$loc->shopify_location_id);
              DB::table('tbl_inventory')->where([
                'inventory_item_id' => $variant->inventory_item_id,
                'shop' => $shop,
                'location_id'=>$loc->shopify_location_id,
                ])->update($saveArray);
            }
        }
      }
    }
      DB::table('webhooks')->insert(['event' => 'product-created','shop_id'=>$shop,'data'=>$response]);
      http_response_code(200);
    }

    public function ProductUpdated(Request $request)
    {
      $response = file_get_contents('php://input');
      $data = json_decode($response);
      $shop = $request->header('x-shopify-shop-domain');
      $ShopifyApiClient = User::where('name',$shop)->first();
      $locations = DB::table('locations')->where([
        'shop'=>$shop
        ])->get();

        if(isset($data->variants)){
          foreach ($data->variants as $key => $variant){
            foreach ($locations as $loc) {
              $users_count = DB::table('tbl_inventory')->where([
                'inventory_item_id'=>$variant->inventory_item_id,
                'shop'=>$shop,
                'location_id'=>$loc->shopify_location_id,
                ])->count();

                if($users_count == 0){
                  $saveArray=[
                    'location_id'=>$loc->shopify_location_id,
                    'inventory_item_id' => $variant->inventory_item_id,
                    'shopify_product_id' => $variant->product_id,
                    'shopify_variant_id' => $variant->id,
                    'shop' => $shop,
                    'event' =>'product-created'
                  ];
                  DB::table('tbl_inventory')->insert($saveArray);
                }else{
                  $saveArray=[
                    'shopify_product_id' => $variant->product_id,
                    'shopify_variant_id' => $variant->id,
                    'event' =>'product-updated-with-creation'
                  ];
                  DB::table('tbl_inventory')->where([
                    'inventory_item_id' => $variant->inventory_item_id,
                    'shop' => $shop,
                    'location_id'=>$loc->shopify_location_id,
                    ])->update($saveArray);
                }
            }
          }
        }
      DB::table('webhooks')->insert(['event' => 'product-updated','shop_id'=>$shop,'data'=>$response]);
      http_response_code(200);
    }


    public function ProductDeleted(Request $request)
    {
      $response = file_get_contents('php://input');
      $data = json_decode($response);
      $shop = $request->header('x-shopify-shop-domain');
      $ShopifyApiClient = User::where('name',$shop)->first();
      $pid = $data->id;
      DB::table('tbl_inventory')->where(['shopify_product_id'=>$pid,'shop'=>$shop])->delete();
      DB::table('webhooks')->insert(['event' => 'product-deleted','data'=>$response,'shop_id'=>$shop]);
      http_response_code(200);
    }

}
