<?php

use feelcom\wsb\Messages;
use feelcom\wsb\CalendarController;

include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/header.php');

?>
    <!-- start of section reservation edit-->

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 panel-content">

        <div class="infobar">
            <?php Messages::display(); ?>
        </div>

        <?php
        //define var for input radio
        $enabled = '';
        $disabled ='';

        if(in_array('admin',$userCan) && isset($_POST['uuid'])){

            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $uuid = $post['uuid'];

        }
        elseif (isset($_SESSION['user_data']['uuid']))
        {

            $uuid = $_SESSION['user_data']['uuid'];
        }
        else {

            header("Location: ".ROOT_URL."users/login");
        }

        $reservationDetail =  CalendarController::getReservationDetail($uuid);
        var_dump($uuid,$_SESSION['user_data']['uuid'], $reservationDetail);


        if($reservationDetail[0]['status']==1){
            $enabled = 'checked';
        }
        else {
            $disabled = 'checked';
        }


        ?>



<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/footer.php');
?>