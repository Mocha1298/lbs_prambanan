<?php

use App\Events\sendName;

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

Route::get('/','Homepage@landing')->name('home');
Route::post('/bergabung','Homepage@bergabung');
Route::post('/join_form','Homepage@join_form');
Route::get('/maps','Homepage@maps');
Route::get('/laporan','Homepage@lapor');

// Route get datapeta
Route::get('/datapeta','Homepage@datapeta');
Route::get('/objek','Homepage@objek');
Route::get('/center/kecamatan/{id}','Homepage@center1');
Route::get('/center/desa/{id}','Homepage@center2');
Route::get('/user','Homepage@user');

// Route::get('/login','AuthController@index')->name('login');
// Route::post('/dashboard','AuthController@postlogin');
// Route::get('/logout','AuthController@logout');
    
Route::group(['middleware' => ['auth','checkrole:1,2']], function () {
    Route::get('/admin','Dashboard@index');
    // Route Master User
    Route::get('/master_user','Master_User@index');//Menampilkan halaman master user
    Route::post('/master_user_tambah','Master_User@create');//Proses tambah user
    Route::post('/master_user_tambah/{id}','Master_User@create2');//Proses tambah user berdasarkan id desa (Untuk Admin Desa) 
    Route::post('/master_user_ubah/{id}','Master_User@update');//Proses ubah data user
    Route::get('/master_user_hapus/{id}','Master_User@destroy');//Proses hapus data user
    Route::get('/aktivasi/{id}','Master_User@disable');//Mengubah status aktivasi user
    Route::get('/profile/{id}','Master_User@profile');
    Route::post('/display/{id}','Master_User@display');
    Route::post('/password/{id}','Master_User@password');

    //Route Master Desa
    Route::get('/master_desa','Master_Desa@index');//Menampilkan Halaman Master Desa
    Route::get('/master_desa/{id}','Master_Desa@index2');//Menampilkan Halaman Master Desa Berdasarkan id Kecamatan
    Route::get('/master_desa_back/{id}','Master_Desa@index3');//Mengembalikan halaman dari kerusakan
    Route::post('/master_desa_tambah','Master_Desa@create');//Proses simpan data
    Route::post('/master_desa_ubah/{id}','Master_Desa@update');//Proses update data
    Route::get('/master_desa_hapus/{id}','Master_Desa@destroy');//Proses hapus data
    Route::post('/master_desa_tambah/{id}','Master_Desa@create2');//Proses simpan data berdasarkan id Kecamatan
    Route::get('/master_desa_hapus/{id}','Master_Desa@destroy');//Proses hapus data berdasarkan id kecamatan

    // Route Master Kecamatan
    Route::get('/master_kecamatan','Master_Kecamatan@index');//Menampilkan Halaman Master Kecamatan
    Route::post('/master_kecamatan_tambah','Master_Kecamatan@create');//Proses simpan data
    Route::post('/master_kecamatan_ubah/{id}','Master_Kecamatan@update');//Proses update data
    Route::get('/master_kecamatan_hapus/{id}','Master_Kecamatan@destroy');//Proses hapus data

    // ROute Master Jenis
    Route::get('/master_jenis','Master_Jenis@index');//Menampilkan Halaman Master Jenis
    Route::post('/master_jenis_tambah','Master_Jenis@create');//Proses tambah data jenis
    Route::post('/master_jenis_ubah/{id}','Master_Jenis@update');//Proses ubah data jenis
    Route::get('/master_jenis_hapus/{id}','Master_Jenis@destroy');//Proses hapus data jenis

    // Route Objek Peta
    Route::get('/objek_peta','Objek_Peta@index');
    Route::post('/objek_peta_tambah','Objek_Peta@create');
    Route::post('/objek_peta_ubah/{id}','Objek_Peta@update');
    Route::get('/objek_peta_hapus/{id}','Objek_Peta@destroy');
    Route::get('/dataobjek','Objek_Peta@dataobjek');

    // Route Objek Kerusakan
    Route::get('/objek_kerusakan/{id}','Objek_Kerusakan@index2');//Menampilkan peta berdasarkan desa
    Route::post('/objek_kerusakan_tambah/{id}','Objek_Kerusakan@create');//Proses tambah berdasarkan desa
    Route::post('/objek_kerusakan_foto/{id}','Objek_Kerusakan@foto');//Proses tambah berdasarkan desa
    Route::post('/objek_kerusakan_ubah/{id}','Objek_Kerusakan@update');//Proses ubah data berdasarkan desa
    Route::post('/objek_kerusakan_status/{id}','Objek_Kerusakan@update1');//Proses ubah status data
    Route::get('/objek_kerusakan_hapus/{id}','Objek_Kerusakan@destroy');
    Route::get('/datapeta_kr/{id}','Objek_Kerusakan@datapeta');
    Route::get('/datapeta_ds/{id}','Objek_Kerusakan@datapeta1');
    Route::get('/center_ds/{id}','Objek_Kerusakan@center');

    // Route Laporan
    Route::get('/suwar_admin/{id}','LaporanAgenda@desa');
    Route::post('/survey/{id}','LaporanAgenda@survey');
    Route::get('/agenda/{id}','LaporanAgenda@agenda');
    Route::get('/valid/{id}','LaporanAgenda@valid');
    Route::get('/suwar_acc/{id}','LaporanAgenda@acc');
    Route::get('/suwar_dis/{id}','LaporanAgenda@dis');
    Route::get('/center_desa','LaporanAgenda@center');
    Route::get('/datapeta_desa','LaporanAgenda@datapeta');
    Route::get('/datapeta_agenda','LaporanAgenda@peta_agenda');

    // Route Laporan Akhir
    Route::get('/report','Report@index');
    Route::get('/cetak','Report@cetak');
});

Route::group(['middleware' => ['auth','checkrole:3']], function (){
    // Route Suara Warga
    Route::get('/my_suwar/{id}','SuaraWarga@index1');
    Route::get('/suwar','SuaraWarga@suwar');
    Route::post('/post_suwar', 'SuaraWarga@create_suwar');
    Route::get('refreshcaptcha', 'SuaraWarga@refreshCaptcha');
    
    Route::post('/u_display/{id}','SuaraWarga@display');
    Route::post('/u_password/{id}','SuaraWarga@password');
});

Auth::routes();

Auth::routes(['verify' => true]);

Route::get('/clear-cache', function() {
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    return "200 OK";
});