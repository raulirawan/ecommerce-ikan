<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class,'transaksi_id','id');
    }
       public function produk()
    {
        return $this->hasOne(Produk::class,'id','produk_id');
    }
    //
}
