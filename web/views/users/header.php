<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Dominik Dymarski, Marcin Dąbrowski, Pietrowski Szymon Filipiak Arkadiusz">
    <title>Rezerwacja wizyt w serwisie samochodowym</title>

    <link rel="icon" type="image/png" href="/assets/img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/assets/img/favicon-16x16.png" sizes="16x16" />

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- custom CSS panel -->
    <link href="/assets/css/custom_admin.css?v=0.00885" rel="stylesheet">

    <!-- fonts CSS -->
    <link href="/assets/css/fonts.css" rel="stylesheet">

    <!-- floating labels CSS -->
    <link href="/assets/css/floating-labels.css" rel="stylesheet">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="infobar">
                <?php feelcom\wsb\Messages::display(); ?>
            </div>
            <div class="login_form">
