<?php
use feelcom\wsb as wsb;

//rozpoczęcie sesji
session_start();

//dołączenie pliku konfiguracyjnegp
require_once('../vendor/feelcom/wsb/config.php');

//przypisanie zapytania URL
$requestUrl = "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";



$bootstrap = new wsb\Bootstrap($requestUrl);

$controller = $bootstrap->createController();



if ($controller) {

    $controller->executeAction();

}