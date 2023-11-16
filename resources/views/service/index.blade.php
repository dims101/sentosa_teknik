@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            {{ __('Daftar Layanan') }}
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="/layanan/tambah" class="btn btn-sm btn-primary">Tambah Layanan</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('message')}}
                    </div>
                    @endif
                    <table id="layananTable" class="display" style="width:100%">
                        <thead class="table-info">
                            <tr>
                                <th>Nama layanan</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Harga Promo</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>{{$service->layanan}}</td>
                                <td class="hargaAsli text-center">{{$service->harga}}</td>
                                <td class="hargaPromo text-center">{{$service->promo}}</td>
                                <td class="text-center">
                                    <a href="/layanan/{{$service->id}}/edit" class="btn btn-sm btn-warning">Edit</a>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $service->id }})">Hapus</button>
                                    <form id="deleteForm_{{ $service->id }}" action="{{ route('service.destroy', $service->id) }}" method="post">
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
    // Fungsi untuk mengubah format harga
    function formatHarga(harga) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(harga);
    }

    // Mengubah harga di tabel menjadi format yang diinginkan
    var tabel = document.getElementById('layananTable');
    var seluruhSel = tabel.querySelectorAll('.hargaPromo, .hargaAsli');

    seluruhSel.forEach(function(sel) {
        var nilaiHarga = parseInt(sel.innerHTML);
        sel.innerHTML = formatHarga(nilaiHarga);
    });
</script>
<script>
    new DataTable('#layananTable');

    function confirmDelete(id) {
        var confirmation = confirm("Apakah Anda yakin ingin menghapus layanan ini?");
        if (confirmation) {
            document.getElementById('deleteForm_' + id).submit();
        }
    }
</script>
@endsection