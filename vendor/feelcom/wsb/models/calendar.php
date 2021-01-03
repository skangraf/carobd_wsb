<?php
namespace feelcom\wsb;

// display names of months in PL language
setlocale(LC_TIME,'pl_PL.UTF8');

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

    function __construct($month=NULL,$year=NULL,$dbh=NULL) {

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
            return $query->fetchAll();
        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }


    }

    /**
     * @param int $month
     * @param int $year
     * @param string $uuid
     * @return array
     *
     * if is given month and year return reservations in specified dates
     * if is given uuid ana user is admin and not given month & year return details of reservation has uuid - id
     * if there is not params and user is admin return all reservations form DB
     *
     */
    public function getReservationsAdm($month=0, $year=0, $uuid='') {

        $pdo= $this->dbh;

        $isAdmin = User::isAdmin();

        if($month==0 && $year ==0 && $uuid !='' && $isAdmin){
            $params = 'WHERE r.reservation_id ='.$uuid;
        }
        elseif ($isAdmin && $month==0 && $year==0){
            $params = '';
        }
        else{
            $params = 'WHERE r.f_month = '.$month.' AND r.f_year='.$year.' AND r.`status`=1';
        }

        $sql = "SELECT `reservation_id`,`date_id`,`f_year`,`f_month`,`f_day`,`cusPhone`,`carRegNo`,r.`carService` as `service`, h.`op_houres` as `houre`, 
       			m.`name` as `make`,t.`name` as `model`, `status`
                FROM `reservations` r 
                JOIN `customers` c ON r.cusId = c.customer_id 
                JOIN `cars` a ON r.carId = a.cars_id 
                JOIN `services` s ON r.carService = s.id 
                JOIN `houres` h ON r.f_hid = h.id 
                JOIN `car_make` m ON a.carMark = m.id_car_make 
                JOIN `car_model` t ON a.carModel = t.id_car_model ".$params;


        try
        {
            $query = $pdo->prepare($sql);
            $query->execute();
            $res = $query->fetchAll();

            $i=0;
            foreach ($res as $row){

                $srvArray = explode("|", $row['service']);

                $res[$i]['service'] = "";


                foreach($srvArray as $idSrv)
                {

                    $sql = "SELECT `name` as `service` FROM `services` WHERE id='$idSrv'";

                    try
                    {
                        $query = $pdo->prepare($sql);
                        $query->execute();
                        $result = $query->fetch();

                        if($res[$i]['service']=="")
                            $res[$i]['service'] = $result['service'];
                        else
                            $res[$i]['service']= $res[$i]['service'].", ".$result['service'];

                    }
                    catch (PDOException $e)
                    {
                        die ($e->getMessage());
                    }

                }

                $i++;
            }

            return $res;
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
            return $query->fetchAll();

        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }

    }

    public function changeStatus(){

        if($_SESSION['is_logged_in'] && User::isAdmin()) {

            // Sanitize POST
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            if (isset($post['uuid']) && isset($post['status'])) {

                $this->editStatus($post['uuid'],$post['status']);

                //set return messages
                if($post['status']==1){
                    Messages::setMsg("Rezerwacja została aktywowana", "success");
                }
                else{
                    Messages::setMsg("Rezerwacja została anulowana", "error");
                }

                return true;
            }

        }

        return false;
    }

    private function editStatus($uuid = '', $status = ''){

        if($uuid!='' && $status!=''){

            $status= intval($status);

            // Update MySQL row
            $this->query("UPDATE reservations SET  status=:status WHERE reservation_id=:uuid");
            $this->bind(':status', $status);
            $this->bind(':uuid', $uuid);
            $this->execute();

            return true;
        }

        return false;
    }




}