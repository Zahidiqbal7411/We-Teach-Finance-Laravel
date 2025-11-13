<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function create()
    {
       

        // Pass all data to your dashboard view
        return view("dashboard.index");
    }
}
