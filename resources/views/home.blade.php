@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            {{ __('Daftar Invoice') }}
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="/invoice/tambah" class="btn btn-sm btn-primary">Tambah Invoice</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('message')}}
                    </div>
                    @endif
                    <table id="example" class="display" style="width:100%">
                        <thead class="table-info">
                            <tr>
                                <th>Kode Invoice</th>
                                <th>Pelanggan</th>
                                <th>Telepon</th>
                                <th>Total bayar</th>
                                <th>Telah dibayarkan</th>
                                <th>Pelunasan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{$invoice->kode_invoice}}</td>
                                <td>{{$invoice->pelanggan}}</td>
                                <td>{{$invoice->telepon}}</td>
                                <td>Rp. {{ number_format($invoice->total_bayar, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($invoice->dibayar, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($invoice->pelunasan, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="/invoice/{{$invoice->id}}/show" class="btn btn-sm btn-success">Cetak</a>
                                    <a href="/invoice/{{$invoice->id}}/edit" class="btn btn-sm btn-warning">Edit</a>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $invoice->id }})">Hapus</button>
                                    <form class="inline-form" id="deleteForm_{{ $invoice->id }}" action="{{ route('invoice.destroy', $invoice->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    new DataTable('#example');

    function confirmDelete(id) {
        var confirmation = confirm("Apakah Anda yakin ingin menghapus invoice ini?");
        if (confirmation) {
            document.getElementById('deleteForm_' + id).submit();
        }
    }
</script>
@endsection