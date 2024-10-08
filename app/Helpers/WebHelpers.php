<?php

namespace App\Helpers;

use App\Models\MenuAccess;
use App\Models\Setting;
use App\Models\SubMenuAccess;
use Illuminate\Support\Facades\Auth;

class WebHelpers
{
  
    public static function setting()
    {
        $setting = Setting::first();
        return $setting;
    }
}
