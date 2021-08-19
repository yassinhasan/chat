<?php

use System\Application;
use System\File;
use System\Session;

require_once "Vendor/System/Application.php";
require_once "Vendor/System/File.php";

$file = new File(dirname(__FILE__));
$app = new Application($file);
$app->run();

// TODO: fenish db controller and models






