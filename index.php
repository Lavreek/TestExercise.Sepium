<?php

if (!defined('PROJECT_ROOT_PATH')) {
    define('PROJECT_ROOT_PATH', __DIR__ .'/');
}

if (!defined('PROJECT_SRC_PATH')) {
    define('PROJECT_SRC_PATH', PROJECT_ROOT_PATH .'src/');
}

if (!defined('PROJECT_BUNDLE_PATH')) {
    define('PROJECT_BUNDLE_PATH', PROJECT_ROOT_PATH .'bundle/');
}

if (!defined('PROJECT_INI_CONFIGURATION')) {
    define('PROJECT_INI_CONFIGURATION', PROJECT_ROOT_PATH .'.env');
}

if (!defined('PROJECT_VAR_PATH')) {
    define('PROJECT_VAR_PATH', PROJECT_ROOT_PATH .'var/');
}

if (!defined('PROJECT_LOCK_PATH')) {
    define('PROJECT_LOCK_PATH', PROJECT_VAR_PATH .'lock/');
}

if (!defined('PROJECT_LOG_PATH')) {
    define('PROJECT_LOG_PATH', PROJECT_VAR_PATH .'log/');
}

if (!defined('PROJECT_MIGRATION_PATH')) {
    define('PROJECT_MIGRATION_PATH', PROJECT_ROOT_PATH .'migrations/');
}

require_once PROJECT_SRC_PATH . "Loader.php";

Loader::initialize();
Loader::initializeBundles();
Loader::initializeOther(PROJECT_ROOT_PATH . 'requests/');
Database::createTables();

$controller = new Controller();
$controller->createModel();
$controller->createView();

echo $controller->response();
