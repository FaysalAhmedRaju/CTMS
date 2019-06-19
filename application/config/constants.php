<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
|--------------------------------------------------------------------------
| Site Resources Paths
|--------------------------------------------------------------------------
|
| Here we keep the paths for images, javascripts and css
| Shemul- Jul 08, 2014
*/

if(substr($_SERVER['REMOTE_ADDR'],0,7)=="192.168" or substr($_SERVER['REMOTE_ADDR'],0,4)=="10.1")
{
	define('BASE_PATH', 'http://192.168.16.65/myportpanel/');
}
else 
{
	if($_SERVER['SERVER_NAME']=="115.127.51.199")
		define('BASE_PATH', 'http://115.127.51.199/myportpanel/');
	else
		define('BASE_PATH', 'http://180.211.170.142/myportpanel/');
}

//define('BASE_PATH', 'http://192.168.16.42/myportpanel/');
define('BASE_PATH_GEN', BASE_PATH.'index.php/');
define('HOME_PAGE', BASE_PATH.'index.php/home');
define('IMG_PATH', BASE_PATH.'resources/images/');
define('IMG_PATH2', BASE_PATH.'resources/signature/');
define('JS_PATH', BASE_PATH.'resources/scripts/');
define('CSS_PATH', BASE_PATH.'resources/styles/');
define('GAL_PATH', BASE_PATH.'resources/images/gallery/');
define('JTY_SIG_PATH', BASE_PATH.'resources/images/jetty_sarkar_signature_files/');



define('GEN_TITLE', 'Chittagong Port Authority');
define('DEFAULT_TIMEZONE', 'Asia/Dhaka');





/* End of file constants.php */
/* Location: ./application/config/constants.php */