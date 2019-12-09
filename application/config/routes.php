<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['forums/index'] = 'forums/index';
$route['forums/tambah_subcategory'] = 'forums/tambah_subcategory';
$route['forums/tambah_threads'] = 'forums/tambah_threads';
$route['forums/tambah_comments'] = 'forums/tambah_comments';
$route['forums/tambah_category/(:any)'] = 'forums/tambah_category/$1';
$route['forums/tambah_subcategory/(:any)'] = 'forums/tambah_subcategory/$1';
$route['forums/tambah_threads/(:any)'] = 'forums/tambah_threads/$1';
$route['forums/(:any)'] = 'forums/view/$1';
$route['forums/(:any)/(:any)'] = 'forums/category/$1/$2';
$route['forums/(:any)/(:any)/(:any)'] = 'forums/subcategory/$1/$2/$3';
$route['forums/(:any)/(:any)/(:any)/(:any)'] = 'forums/threads/$1/$2/$3/$4';
$route['forums'] = 'forums/index';
$route['default_controller'] = 'home';
$route['404_override'] = 'my404';
$route['translate_uri_dashes'] = FALSE;
