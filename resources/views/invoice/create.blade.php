@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            {{ __('Buat Invoice Baru') }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="/invoice/store" onsubmit="cleanRupiahValues()">
                        @csrf
                        <div class="mb-3">
                            <label for="pelanggan" class="form-label">Pelanggan</label>
                            <input type="text" class="form-control" id="pelanggan" name="pelanggan" placeholder="Masukan nama pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="number" class="form-control" id="telepon" name="telepon" placeholder="Masukan nomor telepon">
                        </div>
                        <div class="mb-3">
                            <label for="pelanggan" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" placeholder="Masukan alamat" class="form-control" required></textarea>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="pengerjaan" class="form-label">Tanggal pengerjaan</label>
                            <input type="date" class="form-control" id="pengerjaan" name="pengerjaan" required>
                        </div>

                        <div class="mb-3">
                            <label for="teknisi" class="form-label">Teknisi</label>
                            <input type="text" class="form-control" id="teknisi" name="teknisi" placeholder="Masukan nama teknisi" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Tambah keterangan"></textarea>
                        </div>
                        <hr>
                        <label for="layanan">Layanan</label>
                        <div id="layananContainer">
                            <div class="input-group mb-3">
                                <select name="layanan[]" class="form-control mr-3" onchange="hitungTotalHarga()" required>
                                    @foreach($services as $service)
                                    <option value="{{ $service->id }}" data-harga=" {{ $service->harga }}">{{ $service->layanan }} @Rp. {{ number_format($service->harga, 0, ',', '.') }}</option>
                                    @endforeach
                                </select>
                                <select name="jumlahLayanan[]" class="form-control" onchange="hitungTotalHarga()">
                                    @for($i=1;$i<=5;$i++) <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                        <!-- Tambahkan opsi jumlah layanan sesuai kebutuhan -->
                                </select>
                            </div>
                        </div>
                        <div class="text-right mb-3">
                            <button class="btn btn-sm btn-primary" type="button" onclick="tambahLayanan()">Tambah</button>
                        </div>
                        <div class="mb-3">
                            <label for="total_bayar">Total Pembayaran</label>
                            <input type="text" name="total_bayar" id="total_bayar" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="dibayar">Telah dibayar</label>
                            <input type="text" name="dibayar" id="dibayar" class="form-control" oninput="hitungPelunasan();formatRupiah(this)" required>
                        </div>
                        <div class="mb-3">
                            <label for="pelunasan">Pelunasan</label>
                            <input type="text" name="pelunasan" id="pelunasan" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tempo" class="form-label">Tanggal Jatuh Tempo Pembayaran</label>
                            <input type="date" class="form-control" id="tempo" name="tempo">
                        </div>
                        <hr>

                        <a href="/home" class="btn btn-sm btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-sm btn-primary">Buat Invoice</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        hitungTotalHarga();
    });

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
        document.getElementById('total_bayar').value = document.getElementById('total_bayar').value.replace(/[^0-9]/g, '');
        document.getElementById('dibayar').value = document.getElementById('dibayar').value.replace(/[^0-9]/g, '');
        document.getElementById('pelunasan').value = document.getElementById('pelunasan').value.replace(/[^0-9]/g, '');
    }

    function hitungPelunasan() {
        var totalHargaInput = document.getElementById('total_bayar');
        var telahDibayarkanInput = document.getElementById('dibayar');
        var pelunasanInput = document.getElementById('pelunasan');

        var totalHarga = parseFloat(totalHargaInput.value.replace(/[^0-9]/g, '')) || 0;
        var telahDibayarkan = parseFloat(telahDibayarkanInput.value.replace(/[^0-9]/g, '')) || 0;
        var pelunasan = totalHarga - telahDibayarkan;
        // Memformat pelunasan sebagai string dengan pemisah ribuan
        pelunasanInput.value = formatNumber(pelunasan);
    }

    function tambahLayanan() {
        var layananContainer = document.getElementById('layananContainer');
        var inputGroup = document.createElement('div');
        inputGroup.className = 'input-group mb-3';

        var selectLayanan = document.createElement('select');
        selectLayanan.name = 'layanan[]';
        selectLayanan.className = 'form-control mr-3';
        selectLayanan.required = true;
        selectLayanan.onchange = function() {
            hitungTotalHarga();
        };

        @foreach($services as $service)
        var option = document.createElement('option');
        option.value = '{{ $service->id }}';
        option.setAttribute('data-harga', '{{ $service->harga }}');
        option.text = '{{ $service->layanan }} - Rp. {{ number_format($service->harga, 0, ", ", ".") }}';
        selectLayanan.add(option);
        @endforeach

        // Tambahkan combobox jumlah layanan
        var selectJumlahLayanan = document.createElement('select');
        selectJumlahLayanan.name = 'jumlahLayanan[]';
        selectJumlahLayanan.className = 'form-control mr-3';
        selectJumlahLayanan.onchange = function() {
            hitungTotalHarga();
        };

        // Tambahkan opsi jumlah layanan
        for (var i = 1; i <= 5; i++) {
            var optionJumlah = document.createElement('option');
            optionJumlah.value = i;
            optionJumlah.text = i;
            selectJumlahLayanan.add(optionJumlah);
        }

        var hapusButton = document.createElement('button');
        hapusButton.type = 'button';
        hapusButton.className = 'btn btn-sm btn-danger';
        hapusButton.textContent = 'Hapus';
        hapusButton.onclick = function() {
            hapusLayanan(this);
        };

        inputGroup.appendChild(selectLayanan);
        inputGroup.appendChild(selectJumlahLayanan);
        inputGroup.appendChild(hapusButton);
        layananContainer.appendChild(inputGroup);

        // Rehitung total harga setiap kali menambah layanan
        hitungTotalHarga();
    }

    function hapusLayanan(button) {
        var layananContainer = document.getElementById('layananContainer');
        var inputGroup = button.parentNode;
        layananContainer.removeChild(inputGroup);

        // Rehitung total harga setiap kali menghapus layanan
        hitungTotalHarga();
    }

    function hitungTotalHarga() {
        var totalHargaInput = document.getElementById('total_bayar');
        var selectLayananList = document.querySelectorAll('select[name="layanan[]"]');
        var selectJumlahLayananList = document.querySelectorAll('select[name="jumlahLayanan[]"]');
        var totalHarga = 0;

        selectLayananList.forEach(function(selectLayanan, index) {
            var selectedOption = selectLayanan.options[selectLayanan.selectedIndex];
            var hargaLayanan = parseFloat(selectedOption.getAttribute('data-harga'));
            var jumlahLayanan = parseInt(selectJumlahLayananList[index].value);
            totalHarga += hargaLayanan * jumlahLayanan;
        });

        // Memformat total harga sebagai string dengan pemisah ribuan
        totalHargaInput.value = formatNumber(totalHarga);
        hitungPelunasan();

    }
</script>
@endsection