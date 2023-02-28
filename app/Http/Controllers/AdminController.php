<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\locations;


class AdminController extends Controller
{


  public function SaveLocation(Request $request)
  {
    // dd($request->all());
    try{
      $location =  new locations;
      $location->shopify_location_id = $request->shopify_location_id;
      $location->shop_id = $request->shop_id;
      $location->location_name = $request->location_name;
      $location->address = $request->address;
      $location->address1 = $request->address1;
      $location->city = $request->city;
      $location->state = $request->state;
      $location->country = $request->country;
      $location->zip_code = $request->zip_code;
      $location->email = $request->email;
      $location->password = $request->password;
      $location->store_hours = $request->store_hours;
      $location->is_geo_manually = $request->is_geo_manually;
      $location->geo_latitiude = $request->geo_latitiude;
      $location->geo_langitude = $request->geo_langitude;
      $save = $location->save();
   }
   catch(\Exception $e){
      echo $e->getMessage();
   }
  }
}
