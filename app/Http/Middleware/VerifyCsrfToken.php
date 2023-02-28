<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

    protected $except = [
        'SaveLocations',
        'User/validatelocation',
        'app-uninstalled',
        'inventory-level-connected',
        'inventory-level-disconnected',
        'inventory-level-update',
        'inventory-item-create',
        'inventory-item-update',
        'inventory-item-delete',
        'order-created',
        'product-created',
        'product-updated',
        'product-deleted',
        'submit_locations',
        'submit_settings',
        'checklocation',
        'check-product-available-on-locations',
        'search-locations-inventory'
    ];
}
