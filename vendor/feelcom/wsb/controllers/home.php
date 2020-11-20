<?php
namespace feelcom\wsb;

class HomeController extends Controller{

    protected function getName() {
        return 'home';
    }

    protected function Index(){
        $this->returnView('index');
    }

    protected function error(){
        $this->returnView('404');
    }
}
?>