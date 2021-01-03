$(document).ready(function () {

    let allowAjaxSend = true;

    $(".panel-content").on('click', '#checkAdmReservations', function () {

        // add adm data var to check form
        $('#checkForm').data('adm','68GAeNjbLByV2qAg');

        //show check Modal
        $('#checkModal').modal('show');


    });

    $('.submitFormEdit').click(function (){

        $("#reservationEditForm").submit(function(event){
            event.preventDefault();
            sendEditForm();
        });

    });

    function sendEditForm(){

        if (allowAjaxSend)
        {

            let chosenSrvs = $("#carService").val();
            chosenSrvs = chosenSrvs.toString();
            chosenSrvs = chosenSrvs.replace(/,/g,'|');
            $("#carService").val(chosenSrvs);

            $.ajax({
                url: "/api",
                type: 'POST',
                data: 'action=sendEditFormAjax&carService='+chosenSrvs+'&'+$('form.reservationEditForm').serialize(),
                beforeSend: function(){
                    allowAjaxSend = false;
                },
                complete: function(){
                    allowAjaxSend = true;
                },
                success: function(msg){
                    if(msg.length){
                        let ret = JSON.parse(msg);

                        if(ret['code'] === 0){
                            window.location.href = "/calendar/reservations";
                        }
                        else{
                            infoModal('Przepraszamy wystąpił błąd: <br><br>'+ret['error']+' <br><br> Prosimy przeładować stronę i spróbować ponownie ');
                        }
                    }
                }
            });
        }
    }

})


