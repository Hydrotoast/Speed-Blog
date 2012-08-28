<?php

// This page should ony be called as an instance in another page.
if (!defined('IN_BLOG'))
	exit;

include_once("ConfigRegistry.php");
include_once("constants.php");

$config = ConfigRegistry::getInstance();
$config->set('db_engine', 'sqlite');
$config->set('debug', true);

if ($config->get('debug'))
	error_reporting(E_ALL);

$dsn = sprintf('%s:%s', $config->get('db_engine'), DB_NAME);
$db = new PDO($dsn);

?>
