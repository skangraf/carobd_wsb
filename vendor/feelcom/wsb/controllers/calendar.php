<?php
namespace feelcom\wsb;

use DateTime;

class CalendarController extends Controller{

    protected function getName() {
        return 'calendar';
    }

    protected function Index(){

        $this->returnView('index');
    }

    public function userReservation() {

        $model = new Calendar();

        if ($model) {
            return $this->returnView('calendar',$model);
        }
        else {
            $this->redirect('users', 'register');
        }

    }

    public function getHoures($id=NULL,$year=NULL,$month=NULL,$cnt=NULL,$reservations=array()) {

        // variable definitions
        $div = "";
        $workday  = "";
        $saturday = "";

        // Concat parts of date to string
        $reqDate= $year.'-'.$month.'-'.$cnt;

        // format requested date
        $reqDate = date("d-m-Y", strtotime($reqDate));


        // Create object current date
        $dDay  = new DateTime();

        // try to create object current date
        try
        {
            $reqDateformated  = new DateTime($reqDate);
        }
        catch (Exception $e)
        {
            die ($e->getMessage());
        }

        // make & format diff between dates
        $dDiff = $reqDateformated->diff($dDay);
        $diffInDays = (int)$dDiff->format("%r%a");

        // Generate div for offdays
        $dayoff = "<div class='houre_row'>
						<div class='reservation-desc finished'>
							<div class='reservation-time'>&nbsp;</div>
							<div class='reservation-title'>nieczynne</div>
						</div>
					</div>";


        // if diff in days is grather than 0 then don't generate reservations
        if ($diffInDays > 0)
        {
            $div ="<div class='houre_row'>
						<div class='reservation-desc finished'>
							<div class='reservation-time'>Rezerwacje </div>
							<div class='reservation-title'>zakończone</div>
						</div>
				 </div>";
        }
        else
        {

            $day = $id;

            //get operating houres from DB
            $houres = (new Calendar)->getHoures();

            if (!empty($houres)) {

                $i=0;
                foreach ($houres as $res) {

                    $class = "res_avail";
                    $class_desc = "";
                    $title = "Zarezerwuj";
                    $resID = 0;

                    $divId = $res['id'].$cnt.$month.$year;

                    if($reservations){

                        if(array_search($divId, array_column($reservations, 'date_id'))) {
                            $class = "";
                            $class_desc = "finished";
                            $title = "Niedostępne";


                        }
                    }


                    // generate div for saturday
                    if ($i < 3) {

                        $saturday .= "<div id='$divId' class='houre_row $class '  data-resid='$resID' data-date='$reqDate' data-year='$year' data-month='$month' data-day='$cnt' data-hid='$res[id]' data-hval='$res[op_houres]'>
									<div class='reservation-desc $class_desc'>
										<div class='reservation-time'><i class='far fa-clock'></i> $res[op_houres]</div>
										<div class='reservation-title'>$title</div>
									</div>
								</div>";
                    }

                    // generate div for work weekdays
                    $workday = $saturday;

                    $workday .= "<div id='$divId' class='houre_row $class data-date='$reqDate' data-year='$year' data-month='$month' data-day='$cnt' data-hid='$res[id]' data-hval='$res[op_houres]'>
									<div class='reservation-desc $class_desc'>
										<div class='reservation-time'><i class='far fa-clock'></i> $res[op_houres]</div>
										<div class='reservation-title'>$title</div>
									</div>
								</div>";
                    $i++;
                }
            }

            if ($day<5) {
                $div .= $workday;
            }
            elseif ($day==5) {
                $div .= $saturday;
            }
            else {
                $div .= $dayoff;
            }


        }

        return $div;

    }










}