<?php
namespace feelcom\wsb;

// define timezone for Poland (in the case if it is not set in php.ini)
date_default_timezone_set('Europe/Warsaw');

// Definicja parametrów DB
define("DB_HOST", "localhost:3307");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");


// Definicja protokołu, adresu witryny
define("PROTOCOL", "https://");
define("ROOT_DOMAIN", "domain_name/");
define("ROOT_URL", PROTOCOL . ROOT_DOMAIN);

//definicja dni do kalendarza
define("WEEKDAYS", array('Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota','Niedziela'));
define("WEEKDAYS_SHORT",array('PN','WT','ŚR','CZ','PT','SO','N'));


// define SMS server credentials
define("SerwerSMSUser","user");
define("SerwerSMSPassword","password");

// załadowanie plików aplikacji
foreach (glob("../vendor/feelcom/wsb/app/*.php") as $filename) {
    include_once $filename;
}

// załadowanie plików kontrolerów
foreach (glob("../vendor/feelcom/wsb/controllers/*.php") as $filename) {
    include_once $filename;
}

// załadownaie plików modeli
foreach (glob("../vendor/feelcom/wsb/models/*.php") as $filename) {
    include_once $filename;
}