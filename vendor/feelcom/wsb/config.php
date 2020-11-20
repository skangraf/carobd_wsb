<?php
namespace feelcom\wsb;

// Definicja parametrów DB
define("DB_HOST", "localhost:3307");
define("DB_USER", "db_user");
define("DB_PASS", "db_user_passwd");
define("DB_NAME", "db_name");


// Definicja protokołu, adresu witryny
define("PROTOCOL", "http://");
define("ROOT_DOMAIN", "domain_name/");
define("ROOT_URL", PROTOCOL . ROOT_DOMAIN);

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