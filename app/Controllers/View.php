<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class View extends BaseController
{
    public function about()
    {
        return view('v_about');
    }

    
}
