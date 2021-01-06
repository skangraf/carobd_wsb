<?php

use feelcom\wsb\Messages;
use feelcom\wsb\UsersController;

include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/header.php');

?>
<!-- start of section uzytkownicy-->

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 panel-content">

            <div class="infobar">
                <?php Messages::display(); ?>
            </div>

           <?php
                //define var for input radio
                $enabled = '';
                $disabled ='';

                if(in_array('admin',$userCan) && isset($_POST['uuid'])){

                    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $uuid = $post['uuid'];

                }
                elseif (isset($_SESSION['user_data']['uuid']))
                {

                    $uuid = $_SESSION['user_data']['uuid'];
                }
                else {

                    header("Location: ".ROOT_URL."users/login");
                }

                $userDetail =  UsersController::getUserDetail($uuid);


                if($userDetail['enabled']==1){
                    $enabled = 'checked';
                }
                else {
                    $disabled = 'checked';
                }


           ?>
            <form method="post" class="form-signin" action="<?php echo ROOT_URL; ?>users/editAccount">
                <div class="text-center mb-4">
                    <img class="mb-4" src="../../assets/img/logo.png" alt="logo">
                </div>

                <div class="form-label-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Imię" value="<?php echo $userDetail['name']?>" required>
                    <label for="name">Imię</label>
                </div>

                <div class="form-label-group">
                    <input type="text" id="surname" name="surname" class="form-control" placeholder="Nazwisko" value="<?php echo $userDetail['surname']?>" required>
                    <label for="name">Nazwisko</label>
                </div>

                <div class="form-label-group">
                    <input type="email" id="email" name="email" class="form-control" placeholder="email" value="<?php echo $userDetail['email']?>" required>
                    <label for="name">e-mail</label>
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
                <input type="hidden" id="uuid" name="uuid" value="<?php echo $userDetail['uuid']?>" />
                <input class="btn btn-primary" name="submit" type="submit" value="Zapisz" />
            </form>

            <form method="post" class="form-signin" action="<?php echo ROOT_URL; ?>users/changePassword">

                <div class="text-center mb-4">
                    <h4>Zmiana hasła</h4>
                </div>

                <div class="form-label-group">
                    <input type="password" id="oldPassword" name="oldPassword" class="form-control" placeholder="Hasło" required>
                    <label for="name">Hasło</label>
                </div>

                <div class="form-label-group">
                    <input type="password" id="password1" name="password1" class="form-control" placeholder="Nowe hasło" required>
                    <label for="name">Nowe hasło</label>
                </div>

                <div class="form-label-group">
                    <input type="password" id="password2" name="password2" class="form-control" placeholder="Powtórz hasło" required>
                    <label for="name">Powtórz hasło</label>
                </div>

                <input type="hidden" id="uuid" name="uuid" value="<?php echo $userDetail['uuid']?>" />
                <input class="btn btn-primary" name="submit" type="submit" value="Zmień" />
            </form>
        </main>


<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/footer.php');
?>
