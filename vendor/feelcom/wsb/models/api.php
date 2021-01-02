<?php


namespace feelcom\wsb;

require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \SerwerSMS\SerwerSMS;

use \PDO;
use \PDOException;


class Api extends Model{


    // constructor API Class
    function __construct($dbh=NULL)
    {
        parent::__construct($dbh);
    }

    //check is method exist
    public function actionExist($action=''){

        return method_exists($this, $action);

    }

    public function getReservationUserAjax($params){


        // cerate array variables from string
        $params = explode(',',$params);

        $month = $params[0];
        $year = $params[1];

        $cal = new CalendarController($month,$year);

        // check is object $cal exist
        if (is_object($cal)){

            // $aRet['code'] - 0 mean no error
            $aRet['code'] = 0;
            $aRet['html'] = $cal->userReservationAjax($month,$year);
        }
        else
        {
            // $aRet['code'] - 1 mean there are some errors
            $aRet['code'] = 1;
            $aRet['html'] = "Błąd generowania kalendarza";
        }

        // return JSON answear.
        echo json_encode($aRet);
        exit();
    }

    public function getMarkAjax(){

        $out = array();
        $sql = "SELECT * FROM `car_make` WHERE `id_car_type` = 1";

        try
        {
            $this->query($sql);
            $res = $this->resultSet();

            foreach ($res as $row){

                $out[] = array(
                    'id' => $row['id_car_make'],
                    'name' => $row['name'],
                    'date_create' => $row['date_create'],
                    'date_update' => $row['date_update'],
                );
            }

            return $out;
        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }
    }

    public function getServicesAjax() {

        $out = array();

        $sql = "SELECT * FROM `services`";

        try
        {
            $this->query($sql);
            $res = $this->resultSet();

            foreach ($res as $row){

                $out[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'date_create' => $row['date_create'],
                    'date_update' => $row['date_update'],
                );
            }

            return $out;
        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }
    }

    public function getModelAjax($id=0) {

        $val = (int)$id;

        $out = array();

        $sql = "SELECT * FROM `car_model` WHERE `id_car_make` = '$val'";

        try
        {
            $this->query($sql);
            $res = $this->resultSet();

            foreach ($res as $row){

                $out[] = array(
                    'id' => $row['id_car_model'],
                    'name' => $row['name'],
                    'date_create' => $row['date_create'],
                    'date_update' => $row['date_update'],
                );
            }

            return $out;
        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }
    }


    public function getGenerationAjax($id=0) {

        $val = (int)$id;
        $out = array();
        $sql = "SELECT * FROM `car_generation` WHERE `id_car_model` = '$val'";

        try
        {
            $this->query($sql);
            $res = $this->resultSet();

            foreach ($res as $row){

                $out[] = array(
                    'id' => $row['id_car_generation'],
                    'name' => $row['name'],
                    'year_begin' => $row['year_begin'],
                    'year_end' => $row['year_end'],
                    'date_create' => $row['date_create'],
                    'date_update' => $row['date_update'],
                );
            }

            return $out;
        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }

    }
    public function getSerieAjax($id=0) {

        $val = (int)$id;
        $out = array();
        $sql = "SELECT * FROM `car_serie` WHERE `id_car_generation` = '$val'";

        try
        {
            $this->query($sql);
            $res = $this->resultSet();

            foreach ($res as $row){

                $out[] = array(
                    'id' => $row['id_car_serie'],
                    'name' => $row['name'],
                    'date_create' => $row['date_create'],
                    'date_update' => $row['date_update'],
                );
            }

            return $out;
        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }

    }

    public function getModificationAjax($id=0) {

        $val = (int)$id;
        $out = array();
        $sql = "SELECT * FROM `car_trim` WHERE `id_car_serie` = '$val'";

        try
        {
            $this->query($sql);
            $res = $this->resultSet();

            foreach ($res as $row){

                $out[] = array(
                    'id' => $row['id_car_trim'],
                    'name' => $row['name'],
                    'date_create' => $row['date_create'],
                    'date_update' => $row['date_update'],
                );
            }

            return $out;
        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }

    }


    public function sendReservationFormAjax($form=array()) {


        // cerate array variables from string
        $form = explode(',',$form);

        //create car details array from form array
        $carDetail['carMark'] = $form[1];
        $carDetail['carModel'] = $form[2];
        $carDetail['carGeneration'] = $form[3];
        $carDetail['carSerie'] = $form[4];
        $carDetail['carModification'] = $form[5];
        $carDetail['carService'] = $form[0];
        $carDetail['carRegNo'] = strtoupper($form[6]);

        // set 0 value if var is empty string
        if($carDetail['carGeneration']==''){
            $carDetail['carGeneration']=0;
        }
        if($carDetail['carSerie']==''){
            $carDetail['carSerie']=0;
        }
        if($carDetail['carModification']==''){
            $carDetail['carModification']=0;
        }


        //create customer details array from form array
        $customerDetail['cusName'] = $form[7];
        $customerDetail['cusPhone'] = $form[8];

        //create reservation details array from form array
        $reservationDetail['f_hid'] = $form[9];
        $reservationDetail['f_year'] = $form[10];
        $reservationDetail['f_month'] = $form[11];
        $reservationDetail['f_day'] = $form[12];
        $reservationDetail['carService'] = $form[0];

        //create date_id for unique
        $reservationDetail['date_id'] = $reservationDetail['f_hid'].$reservationDetail['f_day'].$reservationDetail['f_month'].$reservationDetail['f_year'];


        $pdo= $this->dbh;
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        try
        {
            //begin SQL transaction
            $pdo->beginTransaction();

            //insert customer details array to DB - update on duplicate phone
            $sql = "INSERT INTO `customers` (cusName, cusPhone) 
					VALUES (:cusName, :cusPhone) 
					ON DUPLICATE KEY UPDATE cusPhone= :cusPhone,customer_id = LAST_INSERT_ID(customer_id)";
            $query = $pdo->prepare($sql);
            $query->execute($customerDetail);
            $reservationDetail['cusId'] = $pdo->lastInsertId();

            //insert cars details array to DB - update on duplicate carRegNo
            $sql = "INSERT INTO `cars` (`carMark`,`carModel`,`carGeneration`,`carSerie`,`carModification`,`carRegNo`) 
					VALUES (:carMark,:carModel,:carGeneration,:carSerie,:carModification,:carRegNo)
					ON DUPLICATE KEY UPDATE carRegNo= :carRegNo, cars_id = LAST_INSERT_ID(cars_id)";
            $query = $pdo->prepare($sql);
            $query->execute($carDetail);
            $reservationDetail['carId'] = $pdo->lastInsertId();

            //insert reservations details array to DB - on duplicate date_id return error
            $sql = "INSERT INTO `reservations` (`cusId`,`carId`,`carService`,`f_hid`,`f_year`,`f_month`,`f_day`,`date_id`) 
					VALUES (:cusId,:carId,:carService,:f_hid,:f_year,:f_month,:f_day,:date_id)";
            $query = $pdo->prepare($sql);
            $query->execute($reservationDetail);

            //commit SQL transaction
            $pdo->commit();

            //return info
            $res['code'] = 0;
            $res['date_id'] = $reservationDetail['date_id'];
        }
        catch (PDOException $e)
        {
            //rollBack SQL statments if transaction fail
            $pdo->rollBack();

            //return info
            $res['code'] = 1;
            $res['error'] = $e->getMessage();
        }

        return $res;

    }


    //calculateCosts
    public function calculateCostsAjax($carService) {

        $out = array();

        $srvArray = explode("|", $carService);

        try
        {

            foreach($srvArray as $idSrv)
            {

                $sql = "SELECT `name` as `service`, `price` FROM `services` WHERE id='$idSrv'";

                $this->query($sql);
                $res = $this->resultSet();

                array_push($out, $res);
            }

            return $out;

        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }

    }

    public function getUserSMSCodeAjax($phone) {

        $res=0;

        $pdo= $this->dbh;

        $sql = "SELECT * FROM `customers` WHERE cusPhone='".$phone."'";

        try
        {
            $query = $pdo->prepare($sql);
            $query->execute();
            $res = $query->fetchAll();

        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }



        if (!empty($res)){

            $customerID =$res[0]['customer_id'];
            $res = $this->sendSMSCode($phone,$customerID);

        }
        else{
            $res = 0;
        }

        $out['code']=$res;
        $out['phone'] = $phone;

        return json_encode($out);
        exit();

    }

    public function sendSMSCode($phone='',$customerID=0){

        $res = 0;

        $phone = (filter_var($phone, FILTER_SANITIZE_STRING));
        $phone = '+48'.str_replace("-","",$phone);
        $code = mt_rand(100000, 999999);

        $smsCode = $this->sendSMSNotification($code,$phone);


        if($smsCode=='success'){

            $data = [
                'cusID' => intval($customerID),
                'status' => 0,

            ];

            $data1 = [
                'cusID' => intval($customerID),
                'code' => $code,
                'status' => 1,

            ];

            $pdo= $this->dbh;
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            try
            {
                //begin SQL transaction
                $pdo->beginTransaction();

                $sql = "UPDATE customers_code SET status=:status WHERE customer_id=:cusID";
                $query = $pdo->prepare($sql);
                $query->execute($data);

                //insert customer details array to DB - update on duplicate phone
                $sql = "INSERT INTO `customers_code` (customer_id, sms_code,status) 
					VALUES (:cusID, :code,:status) 
                    ";
                $query = $pdo->prepare($sql);
                $query->execute($data1);


                //commit SQL transaction
                $pdo->commit();
                $res =1;

            }
            catch (PDOException $e)
            {
                //rollBack SQL statments if transaction fail
                $pdo->rollBack();

                //return info
                $res = $e->getMessage();
            }

        }

        return $res;


    }


    public function sendSMSNotification($data=array(),$sPhone=0){

        $res = false;

        if(!empty($data) && $sPhone>0)
        {

            $sMesage ="carobd.pl kod potwierdzający: ".$data;



            try{
                $serwersms = new SerwerSMS(SerwerSMSUser,SerwerSMSPassword);

                // SMS FULL
                $res = $serwersms->messages->sendSms(
                    $sPhone,
                    $sMesage,
                    'FEELCOM',
                    array(
                        'test' => false,
                        'details' => true
                    )
                );

                // SMS ECO
                /*   $res  = $serwersms->messages->sendSms(
                       $sPhone,
                       $sMesage,
                       null,
                       array(
                           'test' => true,
                           'details' => true
                       )
                   );*/


                if ($res->success){
                    $res='success';
                }
                else{
                    $res='Błąd wysyłki SMS';
                }

            } catch(Exception $e){
                $res = $e->getMessage();
            }
        }

        return $res;

    }

    public function checkReservationUserAjax($form){

        // cerate array variables from string
        $form = explode(',',$form);

        $out ='';

        $code = $form['0'];
        $phone = $form['1'];


        if ($phone!='' && $code!=''){

            $pdo= $this->dbh;

            $sql = "SELECT * FROM `customers_code` WHERE sms_code ='".$code."' AND status ='1' AND  customer_id =(SELECT customer_id FROM customers WHERE cusPhone = '".$phone."')";

            try
            {
                $query = $pdo->prepare($sql);
                $query->execute();
                $res = $query->fetchAll();

            }
            catch (PDOException $e)
            {
                die ($e->getMessage());
            }



            if (!empty($res)){

                $out = $this->checkReservation($phone);

            }

        }

        return $out;

    }


    private function checkReservation($phone='') {


        $pdo= $this->dbh;

        $out = array();

        $sql = "SELECT `f_year`,`f_month`,`f_day`,`cusPhone`,`carRegNo`,r.`carService` as `service` , h.`op_houres` as `houre`, m.`name` as `make`,t.`name` as `model` FROM `reservations` r 
                JOIN `customers` c ON r.cusId = c.customer_id 
                JOIN `cars` a ON r.carId = a.cars_id 
                JOIN `houres` h ON r.f_hid = h.id 
                JOIN `car_make` m ON a.carMark = m.id_car_make 
                JOIN `car_model` t ON a.carModel = t.id_car_model 
                WHERE c.cusPhone = '$phone' AND r.`status`=1";

        try
        {
            $query = $pdo->prepare($sql);
            $query->execute();
            $res = $query->fetchAll();

            foreach ($res as $row){

                $reqDate= $row['f_year'].'-'.$row['f_month'].'-'.$row['f_day'];
                // format requested date
                $reqDate = date("d-m-Y", strtotime($reqDate));

                $houre = substr($row['houre'],0,5);

                $srvArray = explode("|", $row['service']);
                $row['service'] = "";

                foreach($srvArray as $idSrv)
                {

                    $sql = "SELECT `name` as `service` FROM `services` WHERE id='$idSrv'";

                    try
                    {
                        $query = $pdo->prepare($sql);
                        $query->execute();
                        $result = $query->fetch();

                        if($row['service']=="")
                            $row['service'] = $result['service'];
                        else
                            $row['service'] = $row['service'].", ".$result['service'];

                    }
                    catch (PDOException $e)
                    {
                        die ($e->getMessage());
                    }

                }

                $out[] = array(
                    'date' => $reqDate,
                    'houre' => $houre,
                    'carRegNo' => $row['carRegNo'],
                    'service' => $row['service'],
                    'make' => $row['make'],
                    'model' => $row['model'],
                );
            }

            return $out;
        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }

    }

}