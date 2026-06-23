<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Dashboard::index');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

$routes->group('layanan', function ($routes) {
    $routes->get('/', 'LayananLaundry::index');
    $routes->get('tambah', 'LayananLaundry::tambah');
    $routes->post('simpan', 'LayananLaundry::simpan');
    $routes->get('edit/(:num)', 'LayananLaundry::edit/$1');
    $routes->post('update/(:num)', 'LayananLaundry::update/$1');
    $routes->post('hapus/(:num)', 'LayananLaundry::hapus/$1');
});

$routes->group('member', function ($routes) {
    $routes->get('/', 'Member::index');
    $routes->get('tambah', 'Member::tambah');
    $routes->post('simpan', 'Member::simpan');
    $routes->get('edit/(:num)', 'Member::edit/$1');
    $routes->post('update/(:num)', 'Member::update/$1');
    $routes->post('hapus/(:num)', 'Member::hapus/$1');
});

$routes->group('antrian', function ($routes) {
    $routes->get('/', 'Antrian::index');
    $routes->get('tambah', 'Antrian::tambah');
    $routes->post('simpan', 'Antrian::simpan');
    $routes->get('detail/(:num)', 'Antrian::detail/$1');
    $routes->post('update-status/(:num)', 'Antrian::updateStatus/$1');
    $routes->post('bayar/(:num)', 'Antrian::bayar/$1');
});

$routes->group('proses-cuci', function ($routes) {
    $routes->get('/', 'ProsesCuci::index');
    $routes->post('selesaikan/(:num)', 'ProsesCuci::selesaikan/$1');
});

$routes->group('keuangan', function ($routes) {
    $routes->get('/', 'Keuangan::index');
    $routes->post('simpan', 'Keuangan::simpan');
});

$routes->group('user-management', function ($routes) {
    $routes->get('/', 'UserManagement::index');
    $routes->get('tambah', 'UserManagement::tambah');
    $routes->post('simpan', 'UserManagement::simpan');
    $routes->get('edit/(:num)', 'UserManagement::edit/$1');
    $routes->post('update/(:num)', 'UserManagement::update/$1');
    $routes->post('hapus/(:num)', 'UserManagement::hapus/$1');
});

