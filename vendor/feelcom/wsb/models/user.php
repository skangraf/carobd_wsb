<?php
namespace feelcom\wsb;

class User extends Model{

    public function register(){

        // Sanitize POST
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $password = hash('sha256',$post['password']);

        if($post['submit']){

            if($post['name'] == '' || $post['surname'] == '' || $post['email'] == '' || $post['password'] == ''){
                Messages::setMsg('Proszę wypełnić wszystkie pola', 'error');
                return;
            }

            if(!empty($this->checkEmailAvailable($post['email']))){
                Messages::setMsg('Konto o podanym adresie email już istnieje', 'error');
                return;
            }

            // Insert into MySQL
            $this->query("INSERT INTO accounts (binuuid, name, surname, email, password) VALUES(UuidToBin(UUID()),:name, :surname, :email, :password)");
            $this->bind(':name', $post['name']);
            $this->bind(':surname', $post['surname']);
            $this->bind(':email', $post['email']);
            $this->bind(':password', $password);
            $this->execute();

            // Verify
            if($this->lastInsertId()){
                return true;
            }
        }

        return false;
    }

    private function checkEmailAvailable($email){

        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $this->query('SELECT * FROM accounts WHERE email=:email AND enabled>0');
        $this->bind(':email', $email);
        $res = $this->single();
        return $res;

    }



    public function editAccount(){

        if($_SESSION['is_logged_in']) {

            // Sanitize POST
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if ($post['submit']) {

                if ($post['name'] == '' || $post['surname'] == '' || $post['email'] == '') {
                    Messages::setMsg('Proszę wypełnić wszystkie pola', 'error');
                    return;
                }

                // Update into MySQL
                $this->query("UPDATE accounts SET  name=:name, surname=:surname, email=:email ,enabled=:status WHERE binuuid=UuidToBin(:uuid)");
                $this->bind(':name', $post['name']);
                $this->bind(':surname', $post['surname']);
                $this->bind(':email', $post['email']);
                $this->bind(':status', $post['status']);
                $this->bind(':uuid', $post['uuid']);
                $this->execute();

                // Verify
                if ($this->rowCount() == 1) {
                    return true;
                }
            }

        }

        return false;

    }

    public function changePassword(){

        if($_SESSION['is_logged_in']) {

            // Sanitize POST
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if ($post['submit']) {

                if ($post['oldPassword'] == '' || $post['password1'] == '' || $post['password2'] == '') {
                    Messages::setMsg('Proszę wypełnić wszystkie pola', 'error');
                    return;
                }

                if ($post['password1']!= $post['password2']) {
                    Messages::setMsg('hasła nie są identyczne', 'error');
                    return;
                }

                if (strlen($post['password1']) < 8) {
                    Messages::setMsg('hasło musi mieć min. 8 znaków', 'error');
                    return;
                }

                $oldPassword = hash('sha256',$post['oldPassword']);
                $newPassword = hash('sha256',$post['password1']);

                $userCan = UsersController::userCan();

                // if is admin check admin password else check user password
                if(in_array('admin',$userCan)){
                    $uuid = $_SESSION['user_data']['uuid'];
                }
                else
                {
                    $uuid = $post['uuid'];
                }

                // Compare Login
                $this->query('SELECT UuidFromBin(binuuid) as uuid  FROM accounts WHERE binuuid=UuidToBin(:uuid) AND password = :password AND enabled=1');
                $this->bind(':uuid', $uuid);
                $this->bind(':password', $oldPassword);
                $row = $this->single();

                // update password when user is authorised to change passwd
                if ($row ) {

                    // Update MySQL row
                    $this->query("UPDATE accounts SET  password=:password WHERE binuuid=UuidToBin(:uuid)");
                    $this->bind(':password', $newPassword);
                    $this->bind(':uuid', $post['uuid']);
                    $this->execute();

                    // Verify
                    if ($this->rowCount() == 1) {
                        return true;
                    }
                }
                else{
                    Messages::setMsg('błędne hasło', 'error');
                    return;
                }
            }

        }

        return false;

    }


    public function changePrivileges(){

        $userCan = UsersController::userCan();

        if($_SESSION['is_logged_in'] && in_array('admin',$userCan)) {

            // Sanitize POST
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (isset($post['uuid'])) {

                $this->removePrivileges($post['uuid']);

                if($post['roles'] !='')
                {
                    $capabilities = explode(',',$post['roles']);

                    foreach ($capabilities as $capability){

                        $this->addPrivileges($post['uuid'],$capability);
                    }

                }

                return true;
            }

        }

        return false;
    }

    private function removePrivileges($uuid = ''){

        if($uuid!=''){
            $this->query('DELETE FROM capabilities_user WHERE user_id = (SELECT id FROM accounts WHERE binuuid = UuidToBin(:uuid))');
            $this->bind(':uuid', $uuid);
            $this->execute();

            return true;
        }

        return false;
    }

    private function addPrivileges($uuid = '', $capabilitiesId=''){

        if($uuid!='' && $capabilitiesId!=''){
            $this->query('INSERT INTO `capabilities_user` (`id`, `user_id`, `capabilities_id`) VALUES (NULL, (SELECT id FROM accounts WHERE binuuid = UuidToBin(:uuid)), :capabilitiesId)');
            $this->bind(':uuid', $uuid);
            $this->bind(':capabilitiesId', $capabilitiesId);
            $this->execute();

            return true;
        }

        return false;
    }


    public function changeStatus(){

        $userCan = UsersController::userCan();

        if($_SESSION['is_logged_in'] && in_array('admin',$userCan)) {

            // Sanitize POST
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            if (isset($post['uuid']) && isset($post['status'])) {

                $this->editStatus($post['uuid'],$post['status']);

                if($post['status']==1){
                    Messages::setMsg("Konto zostało odblokowane", "success");
                }
                else{
                    Messages::setMsg("Konto zostało zablokowane", "error");
                }

                return true;
            }

        }

        return false;
    }

    private function editStatus($uuid = '', $status = ''){

        if($uuid!='' && $status!=''){

            $status= intval($status);

           //var_dump($uuid,$status);die;

            // Update MySQL row
            $this->query("UPDATE accounts SET  enabled=:status WHERE binuuid=UuidToBin(:uuid)");
            $this->bind(':status', $status);
            $this->bind(':uuid', $uuid);
            $this->execute();

            return true;
        }

        return false;
    }

    public function login(){


        // Sanitize POST
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $password = hash('sha256',$post['password']);

        if($post['submit']){

            // Compare Login
            $this->query('SELECT UuidFromBin(binuuid) as uuid, name,surname,email,enabled  FROM accounts WHERE email = :email AND password = :password AND enabled=1');
            $this->bind(':email', $post['email']);
            $this->bind(':password', $password);
            $row = $this->single();



            if($row){
                $_SESSION['is_logged_in'] = true;
                $_SESSION['user_data'] = array(
                    "uuid" => $row['uuid'],
                    "name" => $row['name'],
                    "surname" => $row['surname'],
                    "email" => $row['email']
                );
                return true;
            }
        }
        return false;
    }

    public function capabilities($uuid=''){

        if(isset($_SESSION['is_logged_in'])){

            $res = array();

            if ($uuid==''){
                $uuid = filter_var($_SESSION['user_data']['uuid'],FILTER_SANITIZE_STRING);
            }
            else {
                $uuid = filter_var($uuid,FILTER_SANITIZE_STRING);
            }


            $this->query("SELECT A.name FROM capabilities A 
                                JOIN capabilities_user B 
                                ON B.capabilities_id = A.id 
                                JOIN accounts C 
                                ON B.user_id = C.id
                                WHERE C.binuuid=UuidToBin(:uuid) ");
            $this->bind(':uuid', $uuid);
            $results = $this->resultSet();

            if(!empty($results)){
                $i=0;
                foreach ($results as $row){
                    $res[$i] = $row['name'];
                    $i++;
                }
            }

            return $res;

        }

        return false;

    }

    public function getUsers(){

        $userCan = $this->capabilities();

        if($_SESSION['is_logged_in'] && in_array('admin',$userCan)){

            $this->query('SELECT UuidFromBin(binuuid) as uuid, id, name,surname,email,enabled,expiry FROM accounts WHERE enabled>0');

            return $this->resultSet();

        }

        return false;

    }

    public function getUserDetail($uuid=''){

        $res = array();

        if($_SESSION['is_logged_in']) {



            if ($uuid == '') {
                $uuid = filter_var($_SESSION['user_data']['uuid'], FILTER_SANITIZE_STRING);
            } else {
                $uuid = filter_var($uuid, FILTER_SANITIZE_STRING);
            }


            // Compare Login
            $this->query('SELECT UuidFromBin(binuuid) as uuid, name,surname,email,enabled  FROM accounts WHERE binuuid=UuidToBin(:uuid)');
            $this->bind(':uuid', $uuid);
            $res = $this->single();

            return $res;
        }
        else{

            return $res;
        }

    }

    public function getListCapabilities(){

        $userCan = $this->capabilities();

        if($_SESSION['is_logged_in'] && in_array('admin',$userCan)){

            $this->query('SELECT * FROM capabilities');

            return $this->resultSet();

        }

        return false;

    }

    public static function isAdmin(){

        //define admin variable
        $isAdmin = false;

        //get user permission
        $userCan = UsersController::userCan();

        if(!empty($userCan)) {
            //check is user is admin
            if (in_array('admin', $userCan)) {

                $isAdmin = true;

            }
        }

        return $isAdmin;
    }



}