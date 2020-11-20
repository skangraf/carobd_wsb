$(document).ready(function () {

    Sortable.create(privileges1, {
        animation: 100,
        group: 'list-1',
        draggable: '.list-group-item',
        handle: '.list-group-item',
        sort: true,
        filter: '.sortable-disabled',
        chosenClass: 'active'
    });

    Sortable.create(privileges2, {
        group: 'list-1',
        handle: '.list-group-item'
    });


    $(".form-privileges").submit(function(event){

        event.preventDefault();
        let arr = [];
        arr['roles'] = [];
        arr['uuid'] = $('#uuid').val();

        $('#privileges2 li').each(function(i) {

            arr['roles'][i] = $(this).data('value');

        });
        console.log(arr);

        sendPrivilegesForm(arr);
    });

    function sendPrivilegesForm(arr=[]){

        var form = $('<form action="/users/editPrivileges" method="post">' +
            '<input type="text" name="roles" value="' + arr['roles'] + '" />' +
            '<input type="text" name="uuid" value="' + arr['uuid'] + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();

    }


})


