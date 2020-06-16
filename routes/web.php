<?php

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

Route::get('/','Dashboard@index');

// Route Master User
Route::get('/master_user','Master_User@index');//Menampilkan halaman master user
Route::post('/master_user_tambah','Master_User@create');//Proses tambah user
Route::post('/master_user_tambah/{id}','Master_User@create2');//Proses tambah user berdasarkan id desa (Untuk Admin Desa) 
Route::post('/master_user_ubah/{id}','Master_User@update');//Proses ubah data user
Route::get('/master_user_hapus/{id}','Master_User@destroy');//Proses hapus data user

//Route Master Desa
Route::get('/master_desa','Master_Desa@index');//Menampilkan Halaman Master Desa
Route::post('/master_desa_tambah','Master_Desa@create');//Proses simpan data
Route::post('/master_desa_ubah/{id}','Master_Desa@update');//Proses update data
Route::get('/master_desa_hapus/{id}','Master_Desa@destroy');//Proses hapus data
Route::get('/master_desa/{id}','Master_Desa@index2');//Menampilkan Halaman Master Desa Berdasarkan id Kecamatan
Route::post('/master_desa_tambah/{id}','Master_Desa@create2');//Proses simpan data berdasarkan id Kecamatan
Route::get('/master_desa_hapus/{id_k}/{id}','Master_Desa@destroy');//Proses hapus data berdasarkan id kecamatan

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

// Route get datapeta
Route::get('/datapeta','Objek_Kerusakan@datapeta');

// Route Objek Peta
Route::get('/objek_peta','Objek_Peta@index');
Route::get('/objek_peta_tambah','Objek_Peta@create');
Route::post('/objek_peta_tpost','Objek_Peta@store');
Route::get('/objek_peta_ubah','Objek_Peta@edit');
Route::post('/objek_peta_upost','Objek_Peta@update');
Route::get('/objek_peta_hapus/{id}','Objek_Peta@destroy');

// Route Objek Kerusakan
Route::get('/objek_kerusakan/{id}','Objek_Kerusakan@index2');//Menampilkan peta berdasarkan desa
Route::get('/objek_kerusakan_tambah','Objek_Kerusakan@create');
Route::post('/objek_kerusakan_tpost','Objek_Kerusakan@store');
Route::get('/objek_kerusakan_ubah','Objek_Kerusakan@edit');
Route::post('/objek_kerusakan_upost','Objek_Kerusakan@update');
Route::get('/objek_kerusakan_hapus/{id}','Objek_Kerusakan@destroy');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
