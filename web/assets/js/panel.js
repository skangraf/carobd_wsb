$(document).ready(function () {

    feather.replace();

  /*  $('[data-toggle="tooltip"]').tooltip();*/

    $('#users-table').DataTable({
        "scrollX": true,
        "paging": false,
        "language": {
            "url": "/assets/js/Polish.json"
        }
    });


    $("#users-table").on('click', '.fas', function () {

        let uuid = $(this).data('uuid');
        let action = $(this).data('action');
        let status = $(this).data('status');

        if(action === 'uedit'){
            $.redirect("/users/edit",
            {
                uuid: uuid,
            },
            "POST");
        }

        if(action === 'uperrmisions'){
            $.redirect("/users/privileges",
                {
                    uuid: uuid,
                },
                "POST");
        }

        if(action === 'uban'){
            $.redirect("/users/changeStatus",
                {
                    uuid: uuid,
                    status: status,
                },
                "POST");
        }

    });


})


