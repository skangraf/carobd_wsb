</div>

<?php
if ($_SERVER['REQUEST_URI']=='/calendar/panel'){
    include_once($_SERVER['DOCUMENT_ROOT'].'/views/calendar/modals.php');
}

?>
<!-- Modal info  -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">&nbsp;</h5>  <!--  &nbsp for w3c validator error if empty - value is assigned by jQuery on open modal -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="infoMsg">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery JS -->
<script src="/assets/js/jquery-3.4.1.js"></script>

<!-- popper JS-->
<script src="/assets/js/popper.js"></script>

<!-- bootstrap JS -->
<script src="/assets/js/bootstrap.js"></script>

<!-- form JS-->
<script src="/assets/js/form.js?v=0.0038"></script>

<!-- feather JS -->
<script src="/assets/js/feather.min.js"></script>

<!-- sortable JS -->
<script src="/assets/js/sortable.min.js"></script>


<!-- panel redirect JS -->
<script src="/assets/js/jquery.redirect.js"></script>

<!-- panel module JS -->
<script src="/assets/js/panel.js?v=0.0038"></script>

<!-- custom_adm module JS -->
<script src="/assets/js/custom_adm.js?v=0.0038"></script>

<!-- custom module JS -->
<script src="/assets/js/calendar.js?v=0.0038"></script>

<?php

if ($_GET['action']== 'privileges' || $_GET['action']== 'editPrivileges'){
    echo '<script src="/assets/js/privileges.js?v=0.0038"></script>';
}
?>
<!-- datatables JS -->
<script type="text/javascript" src="/assets/js/datatables.min.js"></script>

</body>
</html>