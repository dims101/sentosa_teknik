<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('kode_invoice');
            $table->string('pelanggan');
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('keterangan')->nullable();
            $table->date('tempo')->nullable();
            $table->date('pengerjaan')->nullable();
            $table->string('teknisi')->nullable();
            $table->string('dibayar')->nullable();
            $table->string('total_bayar')->nullable();
            $table->string('pelunasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
