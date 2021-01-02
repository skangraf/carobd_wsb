</div>

<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/views/calendar/modals.php');
?>

<!-- jQuery JS -->
<script src="/assets/js/jquery-3.4.1.js"></script>

<!-- popper JS-->
<script src="/assets/js/popper.js"></script>

<!-- bootstrap JS -->
<script src="/assets/js/bootstrap.js"></script>

<!-- form JS-->
<script src="/assets/js/form.js"></script>

<!-- feather JS -->
<script src="/assets/js/feather.min.js"></script>

<!-- sortable JS -->
<script src="/assets/js/sortable.min.js"></script>


<!-- panel redirect JS -->
<script src="/assets/js/jquery.redirect.js"></script>

<!-- panel module JS -->
<script src="/assets/js/panel.js"></script>

<!-- custom module JS -->
<script src="/assets/js/calendar.js"></script>

<?php

if ($_GET['action']== 'privileges' || $_GET['action']== 'editPrivileges'){
    echo '<script src="/assets/js/privileges.js"></script>';
}
?>
<!-- datatables JS -->
<script type="text/javascript" src="/assets/js/datatables.min.js"></script>

