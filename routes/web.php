<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return 'cache-clear';
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/ikan/{slug}', 'ProdukController@detail')->name('detail.produk');

// PENJUAL
Route::middleware(['auth'])
->group(function () {
    Route::get('akun-saya','ProfilController@index')->name('profil.index');

    Route::post('akun-saya/update','ProfilController@update')->name('profil.update');
    Route::post('akun-saya/ganti-password','ProfilController@updatePassword')->name('change.password');


    Route::get('tambah/keranjang/{id}','CartController@add')->name('cart.add');
    Route::get('hapus-cart/{id}','CartController@delete')->name('cart.delete');

    Route::get('keranjang','CartController@index')->name('cart.index');
    Route::post('update/keranjang','CartController@updateKeranjang')->name('cart.update');

    Route::post('tambah/keranjang','CartController@addCart')->name('cart.add.quantity');





});


Route::prefix('admin')
->middleware(['auth','admin'])
->group(function () {
    Route::get('dashboard','Admin\DashboardController@index')->name('admin.dashboard.index');

    // CRUD PEMBELI
    Route::get('pembeli', 'Admin\PembeliController@index')->name('admin.pembeli.index');
    Route::post('pembeli/create', 'Admin\PembeliController@store')->name('admin.pembeli.store');
    Route::post('pembeli/update/{id}', 'Admin\PembeliController@update')->name('admin.pembeli.update');
    Route::get('pembeli/delete/{id}', 'Admin\PembeliController@delete')->name('admin.pembeli.delete');

     // CRUD PENJUAL
     Route::get('penjual', 'Admin\PenjualController@index')->name('admin.penjual.index');
     Route::post('penjual/create', 'Admin\PenjualController@store')->name('admin.penjual.store');
     Route::post('penjual/update/{id}', 'Admin\PenjualController@update')->name('admin.penjual.update');
     Route::get('penjual/delete/{id}', 'Admin\PenjualController@delete')->name('admin.penjual.delete');

     // CRUD PRODUK
     Route::get('produk', 'Admin\ProdukController@index')->name('admin.produk.index');
     Route::post('produk/create', 'Admin\ProdukController@store')->name('admin.produk.store');
     Route::get('edit/{id}', 'Admin\ProdukController@edit')->name('admin.produk.edit');
     Route::post('produk/update/{id}', 'Admin\ProdukController@update')->name('admin.produk.update');
     Route::get('produk/delete/{id}', 'Admin\ProdukController@delete')->name('admin.produk.delete');
     Route::get('produk/gambar/delete/{id}/{key}', 'Admin\ProdukController@deleteGambar')->name('admin.produk.delete.gambar');

    //  TRANSAKSI
    Route::get('transaksi', 'Admin\TransaksiController@index')->name('admin.transaksi.index');
    Route::get('transaksi/detail/{id}', 'Admin\TransaksiController@detail')->name('admin.transaksi.detail');
    Route::post('transaksi/update/{id}', 'Admin\TransaksiController@update')->name('admin.transaksi.update');

    // WITHDRAW
    Route::get('withdraw', 'Admin\WithdrawController@index')->name('admin.withdraw.index');
    Route::post('withdraw/terima/{id}', 'Admin\WithdrawController@terima')->name('admin.withdraw.terima');
    Route::get('withdraw/tolak/{id}', 'Admin\WithdrawController@tolak')->name('admin.withdraw.tolak');

});


Route::prefix('penjual')
->middleware(['auth','penjual'])
->group(function () {
    Route::get('dashboard','Penjual\DashboardController@index')->name('penjual.dashboard.index');

     // CRUD PRODUK
     Route::get('produk', 'Penjual\ProdukController@index')->name('penjual.produk.index');
     Route::post('produk/create', 'Penjual\ProdukController@store')->name('penjual.produk.store');
     Route::get('edit/{id}', 'Penjual\ProdukController@edit')->name('penjual.produk.edit');
     Route::post('produk/update/{id}', 'Penjual\ProdukController@update')->name('penjual.produk.update');
     Route::get('produk/delete/{id}', 'Penjual\ProdukController@delete')->name('penjual.produk.delete');
     Route::get('produk/gambar/delete/{id}/{key}', 'Penjual\ProdukController@deleteGambar')->name('penjual.produk.delete.gambar');

    //  TRANSAKSI
    Route::get('transaksi', 'Penjual\TransaksiController@index')->name('penjual.transaksi.index');
    Route::get('transaksi/detail/{id}', 'Penjual\TransaksiController@detail')->name('penjual.transaksi.detail');
    Route::post('transaksi/update/{id}', 'Penjual\TransaksiController@update')->name('penjual.transaksi.update');


    // WITHDRAW
    Route::get('withdraw', 'Penjual\WithdrawController@index')->name('penjual.withdraw.index');
    Route::post('withdraw/request/', 'Penjual\WithdrawController@request')->name('penjual.withdraw.request');

     // WITHDRAW
    Route::get('bank', 'Penjual\BankController@index')->name('penjual.bank.index');
    Route::post('bank/create', 'Penjual\BankController@create')->name('penjual.bank.create');
    Route::get('bank/delete/{norek}', 'Penjual\BankController@deleteBank')->name('penjual.bank.delete');

});
// Route::get('/', function () {
//     return view('admin');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

