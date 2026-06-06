<?php
$dev_data = array('id'=>'-1','firstname'=>'Developer','lastname'=>'','username'=>'jcazores','password'=>'5da283a2d990e8d8512cf967df5bc0d0','last_login'=>'','date_updated'=>'','date_added'=>'');
if(!defined('base_url')) define('base_url','https://smartmed-production-5c92.up.railway.app/');
if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
if(!defined('dev_data')) define('dev_data',$dev_data);
if(!defined('DB_SERVER')) define('DB_SERVER', getenv('DB_HOST') ?: 'acela.proxy.rlwy.net');
if(!defined('DB_PORT')) define('DB_PORT', intval(getenv('DB_PORT') ?: 58509));
if(!defined('DB_USERNAME')) define('DB_USERNAME', getenv('DB_USER') ?: 'root');
if(!defined('DB_PASSWORD')) define('DB_PASSWORD', getenv('DB_PASS') ?: 'oCZnrPaBlUHwYSSosvPTWAFRnKiSwQJI');
if(!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'smart_med');
?>