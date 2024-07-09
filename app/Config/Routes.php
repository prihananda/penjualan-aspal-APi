<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('api/aspal_with_stock', 'Aspal::getAspalWithStock');
$routes->get('api/aspal_with_stock/(:segment)', 'Aspal::getAspalWithStockById/$1');
$routes->resource('aspal');

$routes->get('api/stok_aspal_with_jenis_aspal', 'StokAspal::getStokAspalWithJenisAspal');
$routes->get('api/stok_aspal_with_jenis_aspal/(:segment)', 'StokAspal::getStokAspalWithJenisAspalById/$1');
$routes->resource('stok-aspal', ['controller' => 'StokAspal']);

$routes->get('api/kendaraan_with_jenis_aspal', 'Kendaraan::getKendaraanWithJenisAspal');
$routes->get('api/kendaraan_with_jenis_aspal/(:segment)', 'Kendaraan::getKendaraanWithJenisAspalById/$1');
$routes->resource('kendaraan');

$routes->resource('client');
$routes->post('api/login', 'Client::login');
$routes->post('api/signup', 'Client::signup');
$routes->post('api/logout', 'Client::logout');

$routes->resource('pengelola');
$routes->post('api/pengelola/login', 'Pengelola::login');
$routes->post('api/pengelola/logout', 'Pengelola::logout');

$routes->resource('transaksi');
$routes->get('api/data_aspal_katalog', 'Transaksi::getAspalCatalgoue');

$routes->resource('detail_transaksi', ['controller' => 'DetailTransaksi']);
$routes->get('api/detail_transaksi_by_client/(:segment)', 'DetailTransaksi::getByClientId/$1');

$routes->resource('pembayaran');
$routes->get('api/pembayaran_by_client/(:segment)', 'Pembayaran::getByClientId/$1');

$routes->resource('penerima');
$routes->resource('val_pembayaran', ['controller' => 'ValPembayaran']);
$routes->resource('val_transaksi', ['controller' => 'ValTransaksi']);