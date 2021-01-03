<?php

use feelcom\wsb\Messages;
use feelcom\wsb\CalendarController;
use feelcom\wsb\User;
use feelcom\wsb\Api;

include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/header.php');

$uuid ='';

//define var for input radio
$enabled = '';
$disabled ='';

//check if is Admin
$isAdmin = User::isAdmin();


if($isAdmin && isset($_POST['uuid'])){

    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $uuid = $post['uuid'];

}

$reservationDetail =  CalendarController::getReservationDetail($uuid);

$details = $reservationDetail[0];

if($details['status']==1){
    $enabled = 'checked';
}
else {
    $disabled = 'checked';
}

$api = new Api();

$markes = $api->getMarkAjax();


// check car generations details
$generation='';
$generationDetails = $api->getGeneration($details['carGeneration']);
if(isset($generationDetails[0])){
    $generationDetails = $generationDetails[0];
}


if(isset($generationDetails['year_begin']) || isset($generationDetails['year_end'])){
    $generation = $generationDetails['year_begin'].'-'.$generationDetails['year_end'];
}

// check car serie details
$serie='';
$serieDetails = $api->getSerie($details['carSerie']);

if(isset($serieDetails[0])){
    $serieDetails = $serieDetails[0];
}

if(isset($serieDetails['name'])){
    $serie = $serieDetails['name'];
}

// check car modification details
$modification='';
$modificationDetails = $api->getModification($details['carModification']);

if(isset($modificationDetails[0])){
    $modificationDetails = $modificationDetails[0];
}


if(isset($modificationDetails['name'])){
    $modification = $modificationDetails['name'];
}

$services = $api->getServicesAjax();
$serviceList = explode('|',$details['serviceList']);

$data = sprintf("%02d-%02d-%04d", $details['f_day'], $details['f_month'], $details['f_year']);

?>
    <!-- start of section reservation edit-->

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 panel-content">

        <div class="infobar">
            <?php Messages::display(); ?>
        </div>
        <h2><?php echo $data.' | '.$details['houre'] ?></h2>


        <form class="reservationEditForm" id="reservationEditForm">
            <div class="form-group">
                <label for="carMark">Marka:</label>
                <select class="form-control" name="carMark" id="carMark" required>
                    <?php
                    foreach ($markes as $mark){

                        $selected ='';

                        //select choosed mark
                        if($mark['id']==$details['carMark']){
                            $selected ='selected';
                        }


                        echo "<option date_create='{$mark['date_create']}' date_update='{$mark['date_update']}' value='{$mark['id']}' $selected>{$mark['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="carModel">Model:</label>
                <select class="form-control" name="carModel" id="carModel" required>
                    <?php echo "<option value=''>-</option>"?>;
                    <option value="<?php echo $details['carModel'] ?>" selected><?php echo $details['model'] ?></option>
                </select>
            </div>

            <div class="form-group">
                <label for="carGeneration">Rok produkcji:</label>
                <select class="form-control" name="carGeneration" id="carGeneration" >
                    <?php echo "<option value=''>-</option>"?>;
                    <option value="<?php echo $details['carGeneration'] ?>" selected><?php echo $generation ?></option>
                </select>
            </div>

            <div class="form-group">
                <label for="carSerie">Nadwozie:</label>
                <select class="form-control" name="carSerie" id="carSerie" >
                    <?php echo "<option value=''>-</option>"?>;
                    <option value="<?php echo $details['carSerie'] ?>" selected><?php echo $serie ?></option>
                </select>
            </div>

            <div class="form-group">
                <label for="carModification">Silnik:</label>
                <select class="form-control" name="carModification" id="carModification" >
                    <?php echo "<option value=''>-</option>"?>;
                    <option value="<?php echo $details['carModification'] ?>" selected><?php echo $modification ?></option>
                </select>
            </div>

            <div class="form-group">
                <label for="carService">Rodzaj usługi:</label>
                <select multiple class="form-control" name="carService" id="carService" required>
                    <?php
                        foreach ($services as $ser){

                            $selected ='';
                            //select chooser services
                            foreach ($serviceList as $row){

                                if($ser['id']==$row){
                                    $selected ='selected';
                                }
                            }

                            echo "<option date_create='{$ser['date_create']}' date_update='{$ser['date_update']}' value='{$ser['id']}' $selected>{$ser['name']}</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="carRegNo">Nr rej.</label>
                <input type="text" class="form-control" id="carRegNo" name="carRegNo" placeholder="Wpisz nr rejestracji" value="<?php echo $details['carRegNo']?>" required>
            </div>

            <div class="form-group">
                <label for="cusName">Imię i nazwisko</label>
                <input type="text" class="form-control" id="cusName" name="cusName" placeholder="Podaj imię i nazwisko" value="<?php echo $details['cusName']?>" required>
            </div>

            <div class="form-group">
                <label for="cusPhone">Nr kontaktowy</label>
                <input type="tel" class="form-control" id="cusPhone" name="cusPhone" placeholder="format: 501-501-501" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" value="<?php echo $details['cusPhone']?>" required>
            </div>

            <div class="form-label-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="aktywne" value="1" <?php echo $enabled?> >
                    <label class="form-check-label" for="aktywne">aktywne</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="nieaktywne" value="0" <?php echo $disabled?> >
                    <label class="form-check-label" for="nieaktywne">nieaktywne</label>
                </div>
            </div>

            <input type="hidden" name="f_hid" id="f_hid" value="<?php echo $details['h_id'] ?>">
            <input type="hidden" name="f_year" id="f_year" value="<?php echo $details['f_year'] ?>">
            <input type="hidden" name="f_month" id="f_month" value="<?php echo $details['f_month'] ?>">
            <input type="hidden" name="f_day" id="f_day" value="<?php echo $details['f_day'] ?>">
            <input type="hidden" name="f_id" id="f_id" value="<?php echo $details['reservation_id'] ?>">

            <a href="/calendar/reservations"  class="btn btn-secondary">Anuluj</a>
            <button id="editReservation" type="submit" class="btn btn-primary submitFormEdit">Zapisz</button>
        </form>


<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/footer.php');
?>