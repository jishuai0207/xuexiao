<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['cas_server_url'] = 'http://192.168.1.7/cas';

$config['phpcas_path'] = $_SERVER['DOCUMENT_ROOT'].'/application/libraries/cas/';

$config['cas_disable_server_validation'] = true;

$config['cas_logout_url'] = 'http://192.168.1.7/portal-web/logout';

$config['cas_index'] = 'http://192.168.1.7/portal-web';
