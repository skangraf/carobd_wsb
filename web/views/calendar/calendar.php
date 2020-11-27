<?php
use feelcom\wsb as wsb;

$cnt=1;
$checkTitle = "Sprawdź rezerwację";
$reservations = $model->getReservations($model->_month,$model->_year);

?>

<!-- data choice row -->
<div class='top-tr'>

    <!-- data choice previous arrow -->
    <div class='flex-tr'>
        <i class='fas fa-angle-double-left fa-3x' id='previous_month' data-year='<?php echo $model->_month ?>' data-month='<?php echo $model->_month ?>'></i>
    </div>


    <!-- data choice month & year select -->
    <div class='flex-tr ' id='choice_date' data-year='$model->_year' data-month='$model->_month'>

        <div class='flex-tr select-flex' id='select-date'>

            <!-- data choice month select -->
            <div class='month'>

                <div class='select'>

                    <div class='select-styled' id='month'>
                        <?php echo $model->_monthName ?>
                    </div>

                    <ul class='select-options month-list'>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='1'>styczeń</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='2'>luty</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='3'>marzec</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='4'>kwiecień</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='5'>maj</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='6'>czerwiec</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='7'>lipec</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='8'>sierpień</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='9'>wrzesień</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='10'>październik</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='11'>listopad</li>
                        <li class='month-options' data-year='<?php echo $model->_year ?>' data-month='12'>grudzień</li>
                    </ul>
                </div>

            </div>


            <!-- data choice year select -->
            <div class='year'>

                <div class='select'>

                    <div class='select-styled' id='year'>
                        <?php echo $model->_year ?>
                    </div>

                    <ul class='select-options year-list'>
                        <li class='year-options' data-year='<?php echo $model->_year ?>' data-month='<?php echo $model->_month ?>'><?php echo $model->_year ?></li>
                        <li class='year-options' data-year='<?php echo $model->_nextYear ?>' data-month='<?php echo $model->_month ?>'><?php echo $model->_nextYear ?></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- data choice next arrow -->
    <div class='flex-tr'>
        <i class='fas fa-angle-double-right fa-3x' id='next_month' data-year='<?php echo $model->_year ?>' data-month='<?php echo $model->_month ?>'></i>
    </div>

</div>

<!-- weekdays full res row -->
<ul class='weekdays'>

    <?php for($i=0; $i<7; $i++){ ?>

        <li><?php echo WEEKDAYS[$i] ?></li>

    <?php } ?>
</ul>
<!--end of weekdays full res row -->

<!-- weekdays mobile res row -->
<ul class='weekdays-short'>

    <?php for($i=0; $i<7; $i++){ ?>

        <li><?php echo WEEKDAYS_SHORT[$i] ?></li>

    <?php } ?>

</ul>
<!-- end of weekdays mobile res row -->

<!-- days of month row -->
<ul class='days'>

    <!-- display days of previous month -->
    <?php
    if ($cnt == 1 && $model->_startDay != 0) {

        for ($i = 0; $i < $model->_startDay; $i++) { ?>
            <li class='last-month'></li>
<?php
        }
    }

    // display days of first week of month
    for ($i = $model->_startDay; $i < 7; $i++) {

        // Concat parts of date to string
        $reqDate= $model->_year.'-'.$model->_month.'-'.$cnt;

        // format requested date
        $reqDate = date("d-m-Y", strtotime($reqDate));


        // generate div for today or other day
        if($model->_year==$model->_todayY && $model->_month == $model->_todayM && $cnt == $model->_todayD) {
?>

        <!-- style for other days.-->
            <li class='kartka-today'><div class='reservation-date' data-date='<?php echo $reqDate ?>'><?php echo $cnt?></div>

                // fill up day by reservation row
<?php
                     echo wsb\CalendarController::getHoures($i,$model->_year,$model->_month,$cnt,$reservations);
?>
            </li>

<?php
        }
        else
        {

?>
    <!-- style for other days.-->
            <li class='kartka-otherday'><div class='reservation-date' data-date='<?php echo $reqDate ?>'><?php echo $cnt ?></div>

                <!-- fill up day by reservation row-->
<?php
                    wsb\CalendarController::getHoures($i,$model->_year,$model->_month,$cnt,$reservations);
?>
            </li>
<?php
        }

        $cnt++;
    }
?>
</ul>

<?php

    // display rest of days in rest of weeks of month (second,third,fourth and fifth week)
    while ($cnt <= $model->_days) {

?>

    <ul class='days'>
<?php
        // the rest of days of month
        for ($i = 0; $i <7; $i++) {

            // Concat parts of date to string
            $reqDate= $model->_year.'-'.$model->_month.'-'.$cnt;

            // format requested date
            $reqDate = date("d-m-Y", strtotime($reqDate));

            if($model->_year==$model->_todayY && $model->_month == $model->_todayM && $cnt == $model->_todayD) {
?>
        <!-- style for other days.-->
                <li class='kartka-today'><div class='reservation-date' data-date='<?php echo $reqDate ?>'><?php echo $cnt ?></div>

<?php
                    // fill up day by reservation row
                    echo  wsb\CalendarController::getHoures($i,$model->_year,$model->_month,$cnt,$reservations);
?>
                </li>
<?php
            }
            else
            {
?>
        <!-- style for other days.-->
                <li class='kartka-otherday'><div class='reservation-date' data-date='<?php echo $reqDate ?>'><?php echo $cnt ?></div>

<?php
                    // fill up day by reservation row
                    echo wsb\CalendarController::getHoures($i,$model->_year,$model->_month,$cnt,$reservations);
?>
                </li>
<?php
            }

            $cnt++;

            // days of next month
            if ($cnt == $model->_days+1 && $model->_lastDay != 0) {
                for ($j = 0; $j < (7 - $model->_lastDay); $j++) {
?>
                    <li class='next-month'></li>
<?php
                }
                break;
            }
        }
?>
    </ul>
<?php
}
?>

<div class='bottom-tr'>
    <div id='check_reservations'><?php echo $checkTitle ?></div>
</div>