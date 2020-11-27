$(document).ready(function () {

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

})


