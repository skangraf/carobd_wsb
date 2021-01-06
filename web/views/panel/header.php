<?php

use feelcom\wsb\Controller;
use feelcom\wsb\UsersController;

    //check is user logged if not redirect to login


if(!isset($_SESSION['is_logged_in'])){
        Controller::redirect('users', 'login');
    }

    //check user permission
    $userCan = UsersController::userCan();

    //define vars for mark active menu
    $dashbord = '';
    $dashbordClass = '';

    $kalendarz = '';
    $kalendarzClass='';

    $rezerwacje = '';
    $rezerwacjeClass = '';

    $uzytkownicy = '';
    $uzytkownicyClass = '';


    //set vars for active menu
    switch ($_SERVER['REQUEST_URI']) {

        case '/calendar/panel':
            $kalendarzClass = 'active';
            $kalendarz = '<span class="sr-only">(current)</span>';
            break;
        case '/calendar/reservations':
            $rezerwacjeClass = 'active';
            $rezerwacje = '<span class="sr-only">(current)</span>';
            break;
        case '/users/lists':
            $uzytkownicyClass = 'active';
            $uzytkownicy = '<span class="sr-only">(current)</span>';
            break;
        case '/users/edit':
            $uzytkownicyClass = 'active';
            $uzytkownicy = '<span class="sr-only">(current)</span>';
            break;

        default:
            $dashbordClass = 'active';
            $dashbord = '<span class="sr-only">(current)</span>';

    }


?>

<!-- Bootstrap core CSS -->
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">

<!-- custom CSS panel -->
<link href="/assets/css/custom_admin.css?v=0.0038" rel="stylesheet">

<!-- custom CSS panel -->
<link href="/assets/css/calendar.css?v=0.0038" rel="stylesheet">

<!-- fonts CSS -->
<link href="/assets/css/fonts.css" rel="stylesheet">

<!-- floating labels CSS -->
<link href="/assets/css/floating-labels.css" rel="stylesheet">

<!-- datatables CSS -->
<link rel="stylesheet" type="text/css" href="/assets/css/datatables.min.css"/>



</head>
<body>

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="/panel"><img class="img-fluid logo-panel" src="/assets/img/logo2.png"></a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="/users/logout">Wyloguj</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    <?php

                    echo '
                            <li class="nav-item">
                                <a class="nav-link '.$dashbordClass.'" href="/panel">
                                <span data-feather="home"></span>
                                Dashboard<span class="sr-only">(current)</span>
                                </a>
                            </li>
                    ';




                    if (in_array('biuro',$userCan)){
                        echo '
                              <li class="nav-item">
                                <a class="nav-link '.$kalendarzClass.'" href="/calendar/panel">
                                  <span data-feather="calendar"></span>
                                  Kalendarz'.$kalendarz.'
                                </a>
                              </li>
                    ';
                    }

                    if (in_array('mechanik',$userCan)){
                        echo '
                              <li class="nav-item">
                                <a class="nav-link '.$rezerwacjeClass.'" href="/calendar/reservations">
                                  <span data-feather="file"></span>
                                  Rezerwacje'.$rezerwacje.'
                                </a>
                              </li>
                        ';
                    }

                    echo '
                          <li class="nav-item">
                            <a class="nav-link '.$uzytkownicyClass.'" href="/users">
                              <span data-feather="users"></span>
                              Użytkownicy'.$uzytkownicy.'
                            </a>
                          </li>
                        ';

                    ?>
                </ul>

            </div>
        </nav>

