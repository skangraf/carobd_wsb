$(document).ready(function () {

    $(".panel-content").on('click', '#checkAdmReservations', function () {

        // add adm data var to check form
        $('#checkForm').data('adm','68GAeNjbLByV2qAg');

        //show check Modal
        $('#checkModal').modal('show');


    });
})


