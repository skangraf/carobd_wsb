$(document).ready(function () {


    var allowAjaxSend = true;


    $("#rezerwacje").on('click', '#previous_month', function () {

        let month = $(this).data('month');
        let year = $(this).data('year');

        if (month === 1) {
            month = 12;
            year--;
        } else {
            month--;
        }

        getReservation(month, year);

    });

    $("#rezerwacje").on('click', '#next_month', function () {

        let month = $(this).data('month');
        let year = $(this).data('year');


        if (month === 12) {
            month = 1;
            year++;
        } else {
            month++;
        }

        getReservation(month, year);

    });

    $("#rezerwacje").on('click', '#month', function () {

        $('.year-list').css('display', 'none');
        $('.month-list').css('display', 'block');
    });

    $("#rezerwacje").on('click', '.month-options', function () {

        $('.month-list').css('display', 'none');

        let month = $(this).data('month');
        let year = $(this).data('year');
        getReservation(month, year);
    });

    $("#rezerwacje").on('click', '#year', function () {

        $('.month-list').css('display', 'none');
        $('.year-list').css('display', 'block');
    });

    $("#rezerwacje").on('click', '.year-options', function () {

        $('.year-list').css('display', 'none');

        let month = $(this).data('month');
        let year = $(this).data('year');
        getReservation(month, year);

    });

    function getReservation(month,year){

        if (allowAjaxSend)
        {
            $.ajax({
                url: "/api",
                type: 'POST',
                data: 'action=getReservationUserAjax&month='+month+'&year='+year,
                beforeSend: function(){
                    allowAjaxSend = false;
                },
                complete: function(){
                    allowAjaxSend = true;
                },

                success: function(msg){
                    if(msg.length){
                        let ret = JSON.parse(msg);
                        console.log(ret['code']);

                        if(ret['code'] === 0){
                            $( '.rezerwacje-card' ).empty();
                            var htmlString = ret['html'];
                            $( '.rezerwacje-card' ).append( htmlString );
                        }
                        else{
                            alert('Przepraszamy wystąpił błąd: \r \n '+ret['html']+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
                        }
                    }
                }

            });
        }

    }


})


