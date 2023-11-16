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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $invoices = Invoice::orderBy('kode_invoice', 'DESC')->get();
        return view('home', compact('invoices'));
    }
    public function landing()
    {
        $services = Service::orderBy('layanan', 'ASC')->get();
        return view('landing', compact('services'));
    }
}
