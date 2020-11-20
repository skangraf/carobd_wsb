<?php
namespace feelcom\wsb;

class UsersController extends Controller{

    protected function getName() {
        return 'users';
    }

    protected function Index(){


        if(isset($_SESSION['is_logged_in'])){

            //check user permission
            $userCan = UsersController::userCan();

            if (in_array('admin',$userCan)){
                $this->redirect('users', 'lists');
            }
            else {
                $this->redirect('users', 'edit');
            }

        }
        else {
            $this->redirect('users', 'login');
        }


    }

    public function register() {
        $this->returnView('register');
    }

    public function createAccount() {

        $model = new User();

        if ($model->register()) {
            Messages::setMsg("Konto utworzone", "success");
            $this->redirect('users', 'lists');
        }
        else {
            $this->redirect('users', 'register');
        }
    }

    public function login(){
        $this->returnView('login');
    }

    public function authenticate() {


        $model = new User();

        if ($model->login()) {
            Messages::setMsg("Zalogowano", "success");
            $this->redirect('panel');
        }
        else {
            Messages::setMsg("Nie udało się zalogować", "error");
            $this->redirect('users', 'login');
        }
    }

    public function logout() {

        unset($_SESSION['is_logged_in']);
        unset($_SESSION['user_data']);
        Messages::setMsg('Wylogowano', 'success');
        $this->redirect('panel');

    }

    public function lists() {

        if(isset($_SESSION['is_logged_in'])) {

            //check user permission
            $userCan = UsersController::userCan();

            //if is admin show users list else show user data to edit
            if (in_array('admin', $userCan)) {
                $this->returnView('lists');
            } else {
                $this->redirect('users', 'edit');
            }
        }
        else{
            $this->redirect('users', 'login');
        }

    }

    public function edit() {

        if($_SESSION['is_logged_in']) {
            $this->returnView('edit');
        }
        else {
            $this->redirect('users', 'login');
        }

    }

    public function editAccount() {

        if($_SESSION['is_logged_in']) {

            $model = new User();

            if ($model->editAccount()) {
                Messages::setMsg("Konto zostało zaktualizowane", "success");
            }
            else
            {
                Messages::setMsg("Konto nie zostało zaktualizowane", "error");
            }

            return $this->edit();

        }
        else {
            $this->redirect('users', 'login');
        }
    }

    public function changePassword() {

        if($_SESSION['is_logged_in']) {

            $model = new User();

            if ($model->changePassword()) {
                Messages::setMsg("Hasło zostało zaktualizowane", "success");
            }

            return $this->edit();

        }
        else
        {
            $this->redirect('users', 'list');
        }
    }


    public function privileges() {

        if($_SESSION['is_logged_in'] && in_array('admin',$this->userCan())) {
            $this->returnView('privileges');
        }
        else {
            $this->redirect('users', 'login');
        }

    }

    public function editPrivileges() {



        if($_SESSION['is_logged_in'] && in_array('admin',$this->userCan())) {

            $model = new User();

            if ($model->changePrivileges()) {
                Messages::setMsg("Uprawnienia zostały zaktualizowane", "success");
            }

            return $this->privileges();

        }
        else
        {
            $this->redirect('users', 'login');
        }
    }

    public function changeStatus() {



        if($_SESSION['is_logged_in'] && in_array('admin',$this->userCan())) {

            $model = new User();

            if ($model->changeStatus()) {

            }

            $this->redirect('users', 'lists');

        }
        else
        {
            $this->redirect('users', 'login');
        }
    }


    public static function userCan($uuid=''){

        return (new User)->capabilities($uuid);

    }

    public static function getUsers(){

        return (new User)->getUsers();

    }

    public static function getUserDetail($uuid){

        return (new User)->getUserDetail($uuid);

    }

    public static function getListCapabilities(){

        return (new User)->getListCapabilities();

    }
}