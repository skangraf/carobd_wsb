<?php

use feelcom\wsb\Messages;
use feelcom\wsb\User;
use feelcom\wsb\UsersController;

include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/header.php');


$users = (new User)->getUsers();

?>
<!-- start of section uzytkownicy-->

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 panel-content">

            <div class="infobar">
                <?php Messages::display(); ?>
            </div>

            <h2>Lista użytkowników</h2>
            <a href="/users/register" class="btn btn-primary add-new-user-button">Dodaj nowego</a>
            <div class="table-responsive">
              <!--  <table class="table table-striped table-sm users-table style='width:100%'">-->
                    <table id="users-table" class="stripe hover"  style="width:100%">
                    <thead>
                    <tr>
                        <th>Lp.</th>
                        <th>Nazwisko</th>
                        <th>Nazwisko</th>
                        <th>E-mail</th>
                        <th>Role</th>
                        <th>Akcje</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=0;
                    foreach ($users as $user){

                        // define class for display locked accounts
                        $disabled='';
                        $title = 'Zablokuj';
                        $status = 2;

                        // set class for display locked accounts
                        if($user['enabled']!=1){
                            $disabled='locked';
                            $title = 'Odblokuj';
                            $status = 1;
                        }

                        //get user role
                        $role = UsersController::userCan($user['uuid']);

                        //convert arrays roles to string
                        $role = implode(", ", $role);

                        $i++;

                        //display user details & actions row
                        echo "<tr>
                                    <td>{$i}</td>
                                    <td class='{$disabled}'>{$user['name']}</td>
                                    <td class='{$disabled}'>{$user['surname']}</td>
                                    <td class='{$disabled}'>{$user['email']}</td>
                                    <td class='{$disabled}'>{$role}</td>
                                    <td>
                                        <i class='fas fa-user-edit' data-toggle='tooltip' data-placement='bottom' data-uuid='{$user['uuid']}' data-action='uedit' title='edytuj'></i>   
                                        <i class='fas fa-users-cog' data-toggle='tooltip' data-placement='bottom' data-uuid='{$user['uuid']}' data-action='uperrmisions' title='uprawnienia'></i>
                                        <i class='fas fa-user-slash' data-toggle='tooltip' data-placement='bottom' data-uuid='{$user['uuid']}' data-status='{$status}' data-action='uban' title='{$title}'></i>
                                    </td>
                                </tr>";
                    }

                    ?>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </main>


<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/views/panel/footer.php');
?>
