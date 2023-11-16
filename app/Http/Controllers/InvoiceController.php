<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Service;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        return view('invoice.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $kode_invoice = "INV-" . Carbon::now()->format('ymdHis');

        for ($i = 0; $i < count($request->layanan); $i++) {
            Order::create([
                'invoice_id' => $kode_invoice,
                'layanan_id' => $request->layanan[$i],
                'jumlah' => $request->jumlahLayanan[$i]
            ]);
        }

        Invoice::create([
            'kode_invoice' => $kode_invoice,
            'pelanggan' => $request->pelanggan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'keterangan' => $request->keterangan,
            'tempo' => $request->tempo,
            'pengerjaan' => $request->pengerjaan,
            'teknisi' => $request->teknisi,
            'dibayar' => $request->dibayar,
            'total_bayar' => $request->total_bayar,
            'pelunasan' => $request->pelunasan,
        ]);

        return redirect('/home')->with('message', 'Berhasil menambahkan invoice!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $orders = Order::select('layanan', 'jumlah', 'promo')
            ->where('invoice_id', $invoice->kode_invoice)
            ->leftJoin('services', 'orders.layanan_id', 'services.id')
            ->get();
        return view('invoice.print', compact('invoice', 'orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $orders = Order::where('invoice_id', $invoice->kode_invoice)->get();
        $services = Service::all();
        return view('invoice.edit', compact('invoice', 'services', 'orders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        Order::where('invoice_id', $invoice->kode_invoice)->delete();

        for ($i = 0; $i < count($request->layanan); $i++) {
            Order::create([
                'invoice_id' => $invoice->kode_invoice,
                'layanan_id' => $request->layanan[$i],
                'jumlah' => $request->jumlahLayanan[$i]
            ]);
        }
        Invoice::where('id', $invoice->id)->update([
            'kode_invoice' => $invoice->kode_invoice,
            'pelanggan' => $request->pelanggan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'keterangan' => $request->keterangan,
            'tempo' => $request->tempo,
            'pengerjaan' => $request->pengerjaan,
            'teknisi' => $request->teknisi,
            'dibayar' => $request->dibayar,
            'total_bayar' => $request->total_bayar,
            'pelunasan' => $request->pelunasan,
        ]);

        return redirect('/home')->with('message', 'Berhasil mengubah invoice!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        Order::where('invoice_id', $invoice->kode_invoice)->delete();
        $invoice = Invoice::findOrFail($invoice->id);
        $invoice->delete();


        return redirect('/home')->with('message', 'Berhasil menghapus invoice!');
    }
}
