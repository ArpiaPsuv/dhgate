<?php

$root=dirname(__FILE__);
error_reporting(E_ALL|E_STRICT);
date_default_timezone_set('Asia/Yakutsk');
$dr = $_SERVER['DOCUMENT_ROOT'];
set_include_path('.'.PATH_SEPARATOR . './application/library'
    .PATH_SEPARATOR.$dr.'/application/models/'
    .PATH_SEPARATOR.$dr.'/application/controllers/'
    .PATH_SEPARATOR.$dr.'/application/views/'
    .PATH_SEPARATOR.$dr.'/../../library/'
    .PATH_SEPARATOR.get_include_path());
include "Zend/Loader.php";
require_once ('Zend/Loader/Autoloader.php');
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);
Zend_Loader::loadClass('Zend_Controller_Front');
Zend_Loader::loadClass('Zend_Config_Ini');         
Zend_Loader::loadClass('Zend_Registry');
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_Db_Table');
Zend_Loader::loadClass('Zend_Controller_Router_Rewrite');
Zend_Loader::loadClass('Zend_Debug');

$config = new Zend_Config_Ini('./application/config.ini', 'general');
$dbAdapter = Zend_Db::factory($config->db->adapter,$config->db->config->toArray()); // new App_Db($config->db->config->toArray());
Zend_Registry::set('db', $dbAdapter);


$db = Zend_Db::factory($config->db->adapter,
$config->db->config->toArray());
Zend_Db_Table::setDefaultAdapter($dbAdapter);
#Zend_Db_Table::setDefaultAdapter($db);

$logger = new Zend_Log();
$writer = new Zend_Log_Writer_Firebug();
$logger->addWriter($writer);

Zend_Registry::set('logger',$logger);

$profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
$profiler->setEnabled(false);
$db->setProfiler($profiler);
$profiler->getQueryProfiles();
$frontController = Zend_Controller_Front::getInstance();
/*
$frontController->registerPlugin(new Zend_Controller_Plugin_ErrorHandler(array(
    'module'     => 'default',
    'controller' => 'error',
    'action'     => 'error'
)));
*/
//$frontController->throwExceptions(true);

//$frontController->registerPlugin(new App_Plugin_Debugger());



$frontController->registerPlugin(new App_Plugin_AntiHack());
$frontController->registerPlugin(new App_Plugin_Acl());
$autoFilter = new App_Plugin_AutoFilter();
$frontController->throwExceptions(true);
Zend_Registry::set('autoFilter',$autoFilter);
$frontController->registerPlugin($autoFilter);

$frontController->setControllerDirectory($dr.'/application/controllers/');
Zend_Layout::startMvc();
#run! 
$frontController->dispatch(); 