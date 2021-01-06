<?php

use feelcom\wsb\Messages;
use feelcom\wsb\Calendar;
use feelcom\wsb\CalendarController;

include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/header.php');


$reservations = (new Calendar)->getReservationsAdm();

?>
    <!-- start of section reservations-->

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 panel-content">

    <div class="infobar">
        <?php Messages::display(); ?>
    </div>

    <h2>Rezerwacje</h2>

    <div class="table-responsive">
        <!--  <table class="table table-striped table-sm users-table style='width:100%'">-->
        <table id="reservation-table" class="stripe hover"  style="width:100%">
            <thead>
            <tr>
                <th>Lp.</th>
                <th>data</th>
                <th>godzina</th>
                <th>nr rej.</th>
                <th>marka</th>
                <th>model</th>
                <th class="service">usługa</th>
                <th>Akcje</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            foreach ($reservations as $row){

                $i++;
                $data = sprintf("%02d-%02d-%04d", $row['f_day'], $row['f_month'], $row['f_year']);

                //define vars to cancel reservations
                $disabled='';
                $status='2';
                $title='Anuluj Rezewację';

                //define vars to activate reservations
                if($row['status']!=1){
                    $disabled='locked';
                    $status=1;
                    $title='Aktywuj Rezewację';
                }

                //display user details & actions row
                echo "<tr>
                                    <td>{$i}</td>
                                    <td class='{$disabled}'>{$data}</td>
                                    <td class='{$disabled}'>{$row['houre']}</td>
                                    <td class='{$disabled}'>{$row['carRegNo']}</td>
                                    <td class='{$disabled}'>{$row['make']}</td>
                                    <td class='{$disabled}'>{$row['model']}</td>
                                    <td class='service {$disabled}'>{$row['service']}</td>
                                    <td>
                                        <i class='fas fa-user-edit' data-toggle='tooltip' data-placement='bottom' data-uuid='{$row['uuid']}' data-action='redit' title='edytuj'></i>   
                                        <i class='fas fa-print' data-toggle='tooltip' data-placement='bottom' data-uuid='{$row['uuid']}' data-action='rprint' title='drukuj'></i>
                                        <i class='fas fa-ban' data-toggle='tooltip' data-placement='bottom' data-uuid='{$row['uuid']}' data-status='{$status}' data-action='rban' title='{$title}'></i>
                                    </td>
                                </tr>";

            }

            ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
</main>



<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/footer.php');
?>
