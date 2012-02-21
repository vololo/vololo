<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/
/**
 * Настройки для локального сервера.
 * Для использования - переименовать файл в config.local.php
 */

/**
 * Настройка базы данных
 */
$config['db']['params']['host'] = 'localhost';
$config['db']['params']['port'] = '3306';
$config['db']['params']['user'] = 'user';
$config['db']['params']['pass'] = 'password';
$config['db']['params']['type']   = 'mysql';
$config['db']['params']['dbname'] = 'vololo';
$config['db']['table']['prefix'] = 'ls_';

$config['path']['root']['web'] = 'http://'.$_SERVER['HTTP_HOST'].'/blog';
$config['path']['root']['server'] = realpath(dirname(__FILE__).'/..');
$config['path']['root']['site'] = 'http://'.$_SERVER['HTTP_HOST'];
$config['path']['offset_request_url'] = '1';
$config['db']['tables']['engine'] = 'MyISAM';
$config['view']['name'] = 'ВОЛОЛО';
$config['view']['description'] = 'Блог ВОЛОЛО';
$config['view']['skin'] = 'new';
$config['sys']['mail']['from_email'] = 'info@vololo.ru';
$config['sys']['mail']['from_name'] = 'ВОЛОЛО';
$config['general']['close'] = false;
$config['general']['reg']['activation'] = false;
$config['general']['reg']['invite'] = false;
$config['lang']['current'] = 'russian';
$config['lang']['default'] = 'russian';
$config['view']['keywords'] = 'ВОЛОЛО, Волгоград, сайты';
$config['router']['page']['linch'] = 'ActionLinch';
return $config;
?>