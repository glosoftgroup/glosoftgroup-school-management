<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */
$route['login'] = "index/login";
$route['([a-zA-Z_-]+)'] = 'index/$1';

$route['admin/login'] = "admin/admin/login";
$route['admin/inventory'] = "admin/admin/inventory";
//Routes For help
$route['admin/help'] = 'admin/admin/help';

$route['admin/rest'] = 'rest/api';
$route['admin/rest/(:any)'] = 'rest/api/$1';
$route['admin/fee_statement'] = "admin/admin/fee_statement";
$route['logout'] = "index/logout";
$route['admin/logout'] = "users/admin/logout";
$route['default_controller'] = "index";
$route['404_override'] = 'index/gotcha';
$route['admin/(login|logout|profile|license|change_password|forgot_password|activity)'] = 'admin/admin/$1';

$route['admin/companies/list/(:any)'] = "companies/admin/index/$1";
$route['admin/companies/All'] = "companies/admin/index";
$route['admin/([a-zA-Z_-]+)'] = '$1/admin';
$route['admin/(search)/(:any)'] = 'admin/admin/search/$1';
$route['admin/([a-zA-Z_-]+)/(:any)'] = '$1/admin/$2';

$route['contact'] = "index/contact";

$route['admin/reset_password/(:any)'] = "users/admin/reset_password/$1";

$route['admin'] = "admin/admin/index";

//Routes For sub_cats
$route['sub_cats/(:num)'] = 'sub_cats/index/$1';
$route['my_sms/(:num)'] = 'index/my_sms/$1';

//api
$route['api'] = 'rest/api';
$route['api/([a-zA-Z_-]+)'] = 'rest/api/$1';
$route['api/([a-zA-Z_-]+)/(:any)'] = 'rest/api/$1/$2';
$route['api/([a-zA-Z_-]+)/(:any)/(:any)'] = 'rest/api/$1/$2/$3';
$route['api/([a-zA-Z_-]+)/(:num)/(:num)/(:num)'] = 'rest/api/$1/$2/$3/$4';

