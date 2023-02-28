<?php

use DB;
if (!function_exists('getYear')) {
  function getYear() {
    $curr_date = date('m/d/Y h:i:s a', time());
    $curr_month = date('m');
    $curr_year = date('Y');
    $api_arr = ['-01', '-04', '-07', '-10'];
    $api_end = '';

    if($curr_month === 1) {
      $api_end = ($curr_year - 1) . $api_arr[3];
    } else if($curr_month > 1 && $curr_month <= 4) {
      $api_end = $curr_year . $api_arr[0];
    } else if($curr_month > 4 && $curr_month <= 7) {
      $api_end = $curr_year . $api_arr[1];
    } else if($curr_month > 7 && $curr_month <= 10) {
      $api_end = $curr_year . $api_arr[2];
    } else if($curr_month > 10 && $curr_month <= 12) {
      $api_end = $curr_year . $api_arr[3];
    }

    // print_r($api_end);
    return $api_end;
  }
}

if (!function_exists('getlatlongbyaddress')) {
  function getlatlongbyaddress($going,$apiKey){
    $address =$going;
    $prepAddr = str_replace(' ','+',$address);
    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$apiKey);
    $output= json_decode($geocode);
    return ['lat'=>$output->results[0]->geometry->location->lat,'long'=>$output->results[0]->geometry->location->lng];
  }
}
if (!function_exists('ReturnLocationData')) {
  function ReturnLocationData($id){
    return DB::table('locations')->where(['id'=>$id])->first();
  }
}


function ReturnCurrenyCode($cc = 'USD')
{
	$cc = strtoupper($cc);
	$currency = array(
	"USD" => "$" ,
	"AUD" => "$" ,
	"BRL" => "R$" ,
	"CAD" => "C$" ,
	"CZK" => "Kč" ,
	"DKK" => "kr" ,
	"EUR" => "€" ,
	"HKD" => "&#36" ,
	"HUF" => "Ft" ,
	"ILS" => "₪" ,
	"INR" => "₹",
	"JPY" => "¥" ,
	"MYR" => "RM" ,
	"MXN" => "&#36" ,
	"NOK" => "kr" ,
	"NZD" => "&#36" ,
	"PHP" => "₱" ,
	"PLN" => "zł" ,
	"GBP" => "£" ,
	"SEK" => "kr" ,
	"CHF" => "Fr" ,
	"TWD" => "$" ,
	"THB" => "฿" ,
	"TRY" => "₺"
	);

	if(array_key_exists($cc, $currency)){
		return $currency[$cc];
	}
}


if (!function_exists('getOrderStatus')) {
  function getOrderStatus($orderno){
    $row = DB::table('location_orders')->select('status')->where(['id'=>$orderno])->first();
    switch ($row->status) {
      case '0':
        return 'Pending';
        break;
      case '1':
      return 'Ready For Delivery';
        break;
      case '2':
      return 'Shipped';
      case '3':
      return 'Deliverd';
        break;
    }
  }
}

if (!function_exists('StatusPage')) {
  function StatusPage($status){
    switch ($status) {
      case '0':
        return 'pending';
        break;
      case '1':
      return 'processing';
        break;
      case '2':
      return 'ready';
      case '3':
      return 'delivered';
        break;
    }
  }
}

if (!function_exists('ReturnViewPage')){
  function ReturnViewPage($status){
    switch ($status) {
      case '0':
        return 'LocationUser.pending_orders';
        break;
      case '1':
      return 'LocationUser.accepted_orders';
        break;
      case '2':
      return 'LocationUser.shipped_orders';
      case '3':
      return 'LocationUser.delivered_orders';
        break;
    }
  }
}


if (!function_exists('distancebylanglat')) {
function distancebylanglat($lat1, $lon1, $lat2, $lon2, $unit) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);
  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
    return ($miles * 0.8684);
  } else {
    return $miles;
  }
}
}
