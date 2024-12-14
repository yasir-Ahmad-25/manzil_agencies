<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;

use App\Models\Back\FinancialModel;
use App\Models\Back\AuthModel;
use App\Models\Back\ticket_model;

class ErrorController extends BaseController {
    public function page_404(){
        return view("admin/page_404", $this->viewData);
    }
}
