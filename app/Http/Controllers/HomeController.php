<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Invoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function landing()
    {
        $services = Service::orderBy('layanan', 'ASC')->get();
        return view('landing', compact('services'));
    }
}
