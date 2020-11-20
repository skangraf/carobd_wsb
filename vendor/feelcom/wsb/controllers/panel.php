<?php
namespace feelcom\wsb;

class PanelController extends Controller{

    protected function getName() {
        return 'panel';
    }

    protected function Index(){
        $this->returnView('index');
    }

    protected function Uzytkownicy(){
        $this->returnView('uzytkownicy');
    }
}
?>