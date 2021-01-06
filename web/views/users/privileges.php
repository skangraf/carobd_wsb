<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/header.php');

use feelcom\wsb\Messages;
use feelcom\wsb\UsersController;

?>
<!-- start of section uzytkownicy-->

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 panel-content">

            <div class="infobar">
                <?php Messages::display(); ?>
            </div>

           <?php

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
                $userCapabilities = UsersController::userCan($uuid);

                $listCapabilities = UsersController::getListCapabilities();





           ?>
            <form class="form-privileges"  id="form-privileges">
                <div class="text-center mb-4">
                    <img class="mb-4" src="../../assets/img/logo.png" alt="logo">
                </div>

                <div class="row">
                    <div class="col-6 privileges-box">
                        <h5>Lista dostępnych uprawnień</h5>
                        <div class="card" style="width: 18rem;">

                            <ul class="list-group" id="privileges1">
                                <?php
                                foreach ($listCapabilities as $capability){

                                    if(!in_array($capability['name'],$userCapabilities)){
                                        echo "
                                                <li class='list-group-item' data-value='{$capability['id']}'>{$capability['name']}</li>
                                            ";
                                    }

                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 privileges-box">
                        <h5>Lista nadanych uprawnień</h5>
                        <div class="card" style="width: 18rem;">
                            <ul  class="list-group" id="privileges2"">
                            <?php
                            foreach ($listCapabilities as $capability){

                                if(in_array($capability['name'],$userCapabilities)){
                                    echo "
                                                <li class='list-group-item' data-value='{$capability['id']}'>{$capability['name']}</li>
                                            ";
                                }

                            }
                            ?>


                            </ul>
                        </div>
                    </div>
                    <div class="form-privileges-footer">
                        <input type="hidden" id="uuid" name="uuid" value="<?php echo $userDetail['uuid']?>" />
                        <input class="btn btn-primary" name="submit" type="submit" value="Zapisz" />
                    </div>

                </div>
            </form>

        </main>


<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/footer.php');
?>
