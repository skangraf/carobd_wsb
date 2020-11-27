<?php
namespace feelcom\wsb;

// Definicja parametrów DB
define("DB_HOST", "localhost:3307");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");


// Definicja protokołu, adresu witryny
define("PROTOCOL", "https://");
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