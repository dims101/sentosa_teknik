@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="/home" class="btn btn-sm btn-secondary">Kembali</a>
                            <button type="button" class="btn btn-sm btn-primary" onclick="simpanPDF()">Simpan PDF</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="invoicePrint">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-flex align-item-center">
                                    <img src="/assets/img/logo-custom.png" class="img-thumbnail mb-1" alt="Logo Sentosa Teknik"> <span class="fw-bold ml-1" style="font-size: 1.5em;">Sentosa Teknik</span>
                                </div>
                                <p> Jombang, Kec. Ciputat, Kota Tangerang Selatan, Banten 15414 <br> +62 821-7977-3965</p>
                            </div>
                            <div class="col-md-8 align-items-center text-right">
                                <h1>Invoice</h1>
                                <h6>{{$invoice->kode_invoice}}</h6>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <p>
                                    <b>KEPADA :</b><br><br>
                                    {{$invoice->pelanggan}} <br>
                                    {{$invoice->alamat}} <br>
                                    {{$invoice->telepon}}
                                </p>
                            </div>
                            <div class="col-md-8 align-items-center text-right">
                                <br><br>
                                <p>
                                    Tanggal Pengerjaan : <br>
                                    {{date("d/m/Y", strtotime($invoice->pengerjaan))}} <br>
                                </p>
                                <p>
                                    Teknisi : <br>
                                    {{$invoice->teknisi}}
                                </p>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Layanan</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}</td>
                                            <td class="text-center">{{$order->layanan}}</td>
                                            <td class="text-center">Rp. {{ number_format($order->promo, 0, ',', '.') }}</td>
                                            <td class="text-center">{{$order->jumlah}}</td>
                                            <td class="text-center">Rp. {{ number_format($order->jumlah*$order->promo, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container row mt-4">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        Keterangan :
                                        <textarea style="max-width:300px;" class="form-control mt-2" rows="4">{{$invoice->keterangan}}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            Pembayaran :<br>
                                            Transfer ke Rekening Bank BRI <br>
                                            No. Rek : 566401032259539<br>
                                            A.N. Risma Yunita
                                            <br>
                                            <br>
                                            Mohon lakukan pembayaran sebelum : {{date("d/m/Y", strtotime($invoice->tempo))}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <br>
                                Sub Total : Rp. {{number_format($invoice->total_bayar, 0, ',', '.')}} <br>
                                Pembayaran diterima: Rp. {{number_format($invoice->dibayar, 0, ',', '.')}} <br>
                                <br>
                                <i>Tagihan : Rp. {{number_format($invoice->pelunasan, 0, ',', '.')}}</i>
                                <br><br>
                                <br><br><br>
                                Dengan hormat,
                                <br>
                                <br>
                                <img style="max-width:100px;" src="/assets/img/ttd.png" alt="">
                                <br>
                                Risma
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function simpanPDF() {
        var element = document.getElementById('invoicePrint');
        var namaFile = '{{$invoice->pelanggan}} - {{$invoice->kode_invoice}}'; // Ganti dengan nama file yang diinginkan
        var opt = {
            margin: 1,
            filename: namaFile + '.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>
@endsection