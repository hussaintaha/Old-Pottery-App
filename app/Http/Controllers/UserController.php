<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use DB;
use App\User;
use App\locations;
use App\Days;
use App\Settings;
use App\Storetiming;
use URL;

class UserController extends Controller
{


    public function Sync(Request $request)
    {
      $allPages = DB::table('pages')->get();
        $shop = 'old-pettery-test-store.myshopify.com';
        $ShopifyApiClient =User::where('name',$shop)->first();
      foreach ($allPages as $key => $page) {
        $pageArray = [
          "page"=> [
            "title"=> $page->title,
            "body_html"=> $page->body_html,
            "template_suffix"=> $page->template,
          ]
        ];

        try {
          // $adjust = $ShopifyApiClient->api()->request('POST','/admin/api/'.getYear().'/pages.json', $pageArray);
          // print_r($adjust);
        } catch (\Exception $e) {
          print_r($e);
        }
        // exit;
      }
    }
}
