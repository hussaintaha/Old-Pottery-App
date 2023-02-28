<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class locations extends Model
{

      protected $fillable = [
        'shopify_location_id',
        'shop_id',
        'location_name',
        'address',
        'address1',
        'city',
        'state',
        'country',
        'zip_code',
        'email',
        'password',
        'store_hours',
        'is_geo_manually',
        'geo_latitiude',
        'geo_langitude'
      ];
}
