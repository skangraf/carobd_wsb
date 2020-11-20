<?php
namespace feelcom\wsb;

class Messages{

    public static function setMsg($text, $type){

        if($type == 'error'){
            $_SESSION['errorMsg'] = $text;
        }
        else {
            $_SESSION['successMsg'] = $text;
        }

    }

    public static function display(){

        if(isset($_SESSION['errorMsg'])){

            echo '
                <div class="alert alert-danger" role="alert" >'
                    .$_SESSION['errorMsg'].
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                    </div>';

            unset($_SESSION['errorMsg']);

        }

        if(isset($_SESSION['successMsg'])){

            echo '<div class="alert alert-success" role="alert" >'
                    .$_SESSION['successMsg'].
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div>';
            unset($_SESSION['successMsg']);

        }
    }
}