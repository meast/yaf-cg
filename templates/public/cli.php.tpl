<?php
/**
 * charset:utf-8
 * Yaf CLI入口
 * @appname {&$APP_NAME&}
 * @author {&$AUTHOR&}
 */
define('URL_BASE', strtr($_SERVER['SCRIPT_NAME'], array("\\" => '/', 'index.php' => '')));
define('URL_ENTRANCE',rtrim(URL_BASE . 'index.php','/'));
define('PATH_BASE',dirname(__FILE__));
define('PATH_APP',dirname(dirname(__FILE__)));

if (!extension_loaded('yaf')) {
    #we should load the framework from classes is the extension is not loaded
    #include(PATH_APP . '/frameworkutf8/loader.php');
}

//error_reporting(E_ALL);

$app = new Yaf_Application(PATH_APP . "/app/conf/app.ini", 'development');
//$app->getDispatcher()->dispatch(new Yaf\Request\Simple());
$app->bootstrap()->getDispatcher()->dispatch(new Yaf_Request_Simple());

