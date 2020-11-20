<?php
namespace feelcom\wsb;

use Exception;
use PDO;
use PDOException;

class Bootstrap {

    private $controller;
    private $action;
    private $argument;
    private $request;

    public function __construct($request){

        $this->request = str_replace(ROOT_DOMAIN, "/", $request);
        $this->action = 'index';
        $this->argument = '';
        $this->processRequest();

    }

    public function createController() {



        if(is_object($this->controller)) {

            $parents = class_parents($this->controller);

            if(in_array("feelcom\wsb\Controller", $parents)){

                if(method_exists($this->controller, $this->action)){
                    return $this->controller;
                }
                else {
                    //Metoda nie istnieje
                    header("Location: ".ROOT_URL."home/error/MethodNotExist");
                }
            }
            else {
                // Klasa nie rozszerza klasy Controller
                header("Location: ".ROOT_URL."home/error/ClassNotExtendControllerClass");
            }
        }
        else {
            // Klasa kontrolera nie znaleziona
            header("Location: ".ROOT_URL."home/error/ControllerClassNotFound2");
        }
    }

    private function processRequest() {

        if ($this->request == '/') {
            $this->controller = new HomeController($this->action, $this->argument);
            return;
        }

        $uriExploded = explode("?", $this->request);

        if (count($uriExploded) < 2) {
            $controllerUri = $this->request;
        }
        else {
            // query string in place
            $controllerUri = $uriExploded[0];
            $queryString = $uriExploded[1];
        }


        $components = explode("/", $controllerUri);

        $componentsCount = count($components);

        try {
            // w components[1] zawsze powinien znajdować się nasz kontroler, dlatego próbujemy utworzyć obiekt klasy wg podanej nazwy
            $controllerName = ucfirst(strtolower($components[1]));
            $controllerClass = "feelcom\wsb\\".$controllerName . "Controller";

            if (!class_exists($controllerClass)){
                throw new Exception("ControllerClassNotFound");
            }

            switch ($componentsCount) {
                case 2:
                    // host www & controller
                    $this->action = 'index';
                    break;
                case 3:
                    // host www + controller & method
                    $this->action = $components[2];
                    break;
                case 4:
                    // host www + controller, method & argument
                    $this->action = $components[2];
                    $this->argument = $components[3];
                    break;
                default:
                    // someone try to get not exist
                    throw new Exception('URLNotFound');

            }

            $this->controller = new $controllerClass($this->action, $this->argument);


        }
        catch (Exception $e) {

            header("Location: ".ROOT_URL."home/error/".$e->getMessage());

        }
    }
}