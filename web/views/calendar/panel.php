<?php

use feelcom\wsb\Messages;

include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/header.php');




?>
    <!-- start of section kalendarz-->

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 panel-content">

        <div class="infobar">
            <?php Messages::display(); ?>
        </div>

        <h2>Kalendarz</h2>
        <div id="checkAdmReservations" class="btn btn-primary add-new-user-button">Sprawdź rezerwację</div>

        <div id="rezerwacje">
            <div class="container">
                <div class="rezerwacje-card">
                    <?php
                        echo $this->userReservationAjax();
                    ?>
                </div>
            </div>
        </div>
    </main>


<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/footer.php');
?>
<?php
