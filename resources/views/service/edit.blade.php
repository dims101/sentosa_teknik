@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            {{ __('Edit Layanan') }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="/layanan/{{$service->id}}/update" onsubmit="cleanRupiahValues()">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="layanan" class="form-label">Nama layanan</label>
                            <input type="text" class="form-control" id="layanan" value="{{$service->layanan}}" name="layanan" placeholder="Masukan nama layanan" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga asli</label>
                            <input type="text" class="form-control" id="harga" value="{{ 'Rp ' . number_format($service->harga, 0, ',', '.') }}" name="harga" oninput="formatRupiah(this)" required>
                        </div>
                        <div class="mb-3">
                            <label for="promo" class="form-label">Harga promo</label>
                            <input type="text" class="form-control" id="promo" value="{{ 'Rp ' . number_format($service->promo, 0, ',', '.') }}" name="promo" oninput="formatRupiah(this)" required>
                        </div>
                        <a href="/layanan" class="btn btn-sm btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function formatRupiah(input) {
        document.addEventListener('DOMContentLoaded', function() {
            // Set nilai awal kolom harga dengan format Rupiah
            document.getElementById('harga').value = formatRupiah(0);
            document.getElementById('promo').value = formatRupiah(0);
        });
        // Format input menjadi format Rupiah
        let nilai = input.value.replace(/\D/g, '');
        input.value = formatNumber(nilai);
    }

    function formatNumber(number) {
        // Format angka menjadi format Rupiah dengan titik sebagai pemisah ribuan
        return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function cleanRupiahValues() {
        // Membersihkan nilai dari format Rupiah sebelum disubmit
        document.getElementById('harga').value = document.getElementById('harga').value.replace(/[^0-9]/g, '');
        document.getElementById('promo').value = document.getElementById('promo').value.replace(/[^0-9]/g, '');
    }
</script>
@endsection