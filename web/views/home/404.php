<?php
include_once('header.php');
?>
<div id="notFound" class="col-xs-12 col-md-12 ">
    <div class="text-center mb-4">
        <a href="/">
            <img class="mb-4" src="../../assets/img/logo.png" alt="logo">
        </a>
    </div>
    <div class="not-found-content">
        <div class="not-found-header">
            <h3>Uppsssss.. smth goes wrong</h3>
            <h1>404</h1>
        </div>
        <div clas="not-found-info">
            <?php echo $_GET['id']?>
        </div>
    </div>
</div>

<?php
include_once('footer.php');
?>