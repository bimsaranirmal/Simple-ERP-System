<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['register'] = 'Register_Controller/register';  
$route['login'] = 'Login_Controller/login';

$route['dashboard'] = 'Dashboard_Controller/item';
$route['dashboard/item'] = 'Dashboard_Controller/item';
$route['dashboard/edit/(:num)'] = 'Dashboard_Controller/edit/$1';
$route['dashboard/update'] = 'Dashboard_Controller/update';
$route['dashboard/delete/(:num)'] = 'Dashboard_Controller/delete/$1';
$route['dashboard'] = 'Dashboard_Controller/index';

$route['invoice'] = 'Invoice_Controller/index';
$route['invoice/save'] = 'Invoice_Controller/save';
$route['invoice/edit/(:num)'] = 'Invoice_Controller/edit/$1';
$route['invoice/update'] = 'Invoice_Controller/update';
$route['invoice/delete/(:num)'] = 'Invoice_Controller/delete/$1';

$route['customer'] = 'Customer_Controller/index';
$route['customer/save'] = 'Customer_Controller/save';
$route['customer/edit/(:num)'] = 'Customer_Controller/edit/$1'; 
$route['customer/delete/(:num)'] = 'Customer_Controller/delete/$1';

$route['unit'] = 'Unit_Controller/index';
$route['unit/save'] = 'Unit_Controller/save';
$route['unit/delete/(:num)'] = 'Unit_Controller/delete/$1';

$route['return'] = 'Return_Controller/view_returns';
$route['return/get_invoices_by_customer'] = 'Return_Controller/get_invoices_by_customer';
$route['return/get_invoice_items'] = 'Return_Controller/get_invoice_items';
$route['return/get_all_items'] = 'Return_Controller/get_all_items';
$route['return/get_all_units'] = 'Return_Controller/get_all_units';
$route['return/save'] = 'Return_Controller/save';
$route['return/view_returns'] = 'Return_Controller/view_returns';
$route['return/edit/(:num)'] = 'Return_Controller/edit/$1';
$route['return/update'] = 'Return_Controller/update';
$route['return/delete/(:num)'] = 'Return_Controller/delete/$1';

$route['chart'] = 'Chart_Controller/index';

// Add these routes to your routes.php file
$route['invoiceReport'] = 'InvoiceReport_Controller/index';
$route['invoiceReport/generate_csv'] = 'InvoiceReport_Controller/generate_csv';
$route['invoiceReport/generate_pdf_simple'] = 'InvoiceReport_Controller/generate_pdf_simple';
$route['invoiceReport/print_invoice/(:num)'] = 'InvoiceReport_Controller/print_invoice/$1';

$route['returnReport'] = 'ReturnReport_Controller/index';
$route['returnReport/generate_csv'] = 'ReturnReport_Controller/generate_csv';
$route['returnReport/generate_pdf_simple'] = 'ReturnReport_Controller/generate_pdf_simple';
$route['returnReport/print_return/(:num)'] = 'ReturnReport_Controller/print_return/$1';







