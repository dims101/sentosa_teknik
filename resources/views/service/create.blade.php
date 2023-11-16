@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            {{ __('Tambah Layanan') }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="/layanan/store" onsubmit="cleanRupiahValues()">
                        @csrf
                        <div class="mb-3">
                            <label for="layanan" class="form-label">Nama layanan</label>
                            <input type="text" class="form-control" id="layanan" name="layanan" placeholder="Masukan nama layanan" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga asli</label>
                            <input type="text" class="form-control" id="harga" name="harga" oninput="formatRupiah(this)" required>
                        </div>
                        <div class="mb-3">
                            <label for="promo" class="form-label">Harga promo</label>
                            <input type="text" class="form-control" id="promo" name="promo" oninput="formatRupiah(this)" required>
                        </div>
                        <a href="/layanan" class="btn btn-sm btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function formatRupiah(input) {
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