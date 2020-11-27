<?php
namespace feelcom\wsb;

// display names of months in PL language
setlocale(LC_TIME,'pl_PL.UTF8');


use Exception;
use \PDO;
use \PDOException;





class Calendar extends Model{


    public $_data;
    public $_month;
    public $_monthName;
    public $_year;
    public $_nextYear;
    public $_days;
    public $_day;
    public $_startDay;
    public $_lastDay;
    public $_todayY;
    public $_todayM;
    public $_todayD;

    function __construct($dbh=NULL,$month=NULL,$year=NULL) {

        parent::__construct($dbh);


        if (isset($month)){
            $month = (int)$month;
        }
        else
        {
            $month = date('m');
        }

        if (isset($year)){
            $year = (int)$year;
        }
        else
        {
            $year = date('Y');
        }

        $day = 01;//date('d');

        $this->_data = date($year.'-'.$month.'-'.$day);

        $dt = strtotime($this->_data);
        $this->_month = (int)date('m',$dt);
        $this->_monthName = strftime("%B", mktime(0, 0, 0, $this->_month, 1));
        $this->_year = (int)date('Y',$dt);
        $this->_nextYear = $this->_year+1;
        $this->_day = (int)date('d',$dt);

        $this->_days = cal_days_in_month(CAL_GREGORIAN, $this->_month,$this->_year);

        $dt = mktime(0,0,0, $this->_month,0,$this->_year);
        $this->_startDay = (int)date('w',$dt);
        $this->_lastDay = (int)date('w',mktime(0, 0, 0, $this->_month, $this->_days, $this->_year));

        $this->_todayY = date('Y');
        $this->_todayM = date('m');
        $this->_todayD = date('d');


    }

    public function getReservations($month=0,$year=0) {

        $pdo= $this->dbh;

        $sql = "SELECT * FROM `reservations` WHERE `f_month` = '$month' AND `f_year` = '$year' AND `status`=1";

        try
        {
            $query = $pdo->prepare($sql);
            $query->execute();
            $reservations = $query->fetchAll();
            return $reservations;
        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }


    }



    public function getHoures() {

        $pdo= $this->dbh;

        $sql = "SELECT * FROM `houres`";

        try
        {
            $query = $pdo->prepare($sql);
            $query->execute();
            $houres = $query->fetchAll();
            return $houres;
        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }

    }

}