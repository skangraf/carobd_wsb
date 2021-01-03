+function ($) {

    $(document).ready(function () {

        let allowAjaxSend = true;
        let formButtonFlag = 0;

        //Get cars models on car mark change
        $('#carMark').change(function(){
            console.log('dupa');
            getModel();
        });

        //Get cars gernerations on car model change
        $('#carModel').change(function(){
            getGeneration();
        });

        //Get cars series on car gernerations change
        $('#carGeneration').change(function(){
            getSerie();
        });

        //Get cars engines on car serie change
        $('#carSerie').change(function(){
            getModification();
        });


        //open reservation modal & get car mark
        $("#rezerwacje").on('click','.res_avail',function(){

            //get data for reservation
            let valHVAL = $(this).data('hval');
            let valHID = $(this).data('hid');
            let valY = $(this).data('year');
            let valM = $(this).data('month');
            let valD = $(this).data('day');
            let valDate = $(this).data('date');

            //vars for fillup modal data
            let sLabelTxt = valHVAL+', '+valDate ;


            $('#reservationModalLabel').empty().append(sLabelTxt);

            getMark();

            //Get services on car engines change
            getServices();

            $('#f_hid').val(valHID);
            $('#f_year').val(valY);
            $('#f_month').val(valM);
            $('#f_day').val(valD);


            $('#reservationModal').modal('show');

        });


        function getMark(){
            $('#carMark option').not(':first').remove();
            $('#carModel option').not(':first').remove();
            $('#carGeneration option').not(':first').remove();
            $('#carSerie option').not(':first').remove();
            $('#carModification option').not(':first').remove();

            let request = $.ajax({
                url: "/api",
                method: "POST",
                data: 'action=getMarkAjax',
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#carMark').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }


        function getModel(){
            $('#carModel option').not(':first').remove();
            $('#carGeneration option').not(':first').remove();
            $('#carSerie option').not(':first').remove();
            $('#carModification option').not(':first').remove();


            let model = $('#carMark').val();
console.log(model);
            if(model == '')
                return false;

            let request = $.ajax({
                url: "/api",
                method: "POST",
                data: 'action=getModelAjax&param='+model,
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#carModel').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        function getGeneration(){
            $('#carGeneration option').not(':first').remove();
            $('#carSerie option').not(':first').remove();
            $('#carModification option').not(':first').remove();

            let generation = $('#carModel').val();

            if(generation == '')
                return false;

            let request = $.ajax({
                url: "/api",
                method: "POST",
                data: 'action=getGenerationAjax&param='+generation,
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option year_begin="'+data[i].year_begin+'" year_end="'+data[i].year_end+'" date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].year_begin+'-'+data[i].year_end+'</option>';
                }

                $('#carGeneration').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        function getSerie(){
            $('#carSerie option').not(':first').remove();
            $('#carModification option').not(':first').remove();

            let serie = $('#carGeneration').val();

            if(serie == '')
                return false;

            let request = $.ajax({
                url: "/api",
                method: "POST",
                data: 'action=getSerieAjax&param='+serie,
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#carSerie').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        function getModification(){
            $('#carModification option').not(':first').remove();

            let modification = $('#carSerie').val();

            if(modification == '')
                return false;

            let request = $.ajax({
                url: "/api",
                method: "POST",
                data: 'action=getModificationAjax&param='+modification,
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#carModification').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        function getServices(){
            $('#carService option').not(':first').remove();

            let request = $.ajax({
                url: "/api",
                method: "POST",
                data: 'action=getServicesAjax',
                dataType: "json"
            });

            request.done(function(data){
                let opt = '';

                for(let i = 0, max = data.length; i < max; i++){
                    opt += '<option date_create="'+data[i].date_create+'" date_update="'+data[i].date_update+'" value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#carService').append(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        $('.submitForm').click(function (){

            console.log(this.id);
            if(this.id === 'sendReservation') formButtonFlag = 1;
            else if(this.id === 'calculate') formButtonFlag = 2;

            if(this.id === 'sendReservation') {
                $("#reservationForm").submit(function(event){
                    event.preventDefault();
                    sendReservationForm();
                });
            }
            else if (this.id === 'calculate') {
                $("#reservationForm").submit(function(event){
                    event.preventDefault();
                    calculateCosts();
                });
            }
        });

        function sendReservationForm(){

            if (allowAjaxSend)
            {

                let chosenSrvs = $("#carService").val();
                chosenSrvs = chosenSrvs.toString();
                chosenSrvs = chosenSrvs.replace(/,/g,'|');
                $("#carService").val(chosenSrvs);

                $.ajax({
                    url: "/api",
                    type: 'POST',
                    data: 'action=sendReservationFormAjax&carService='+chosenSrvs+'&'+$('form.reservationForm').serialize(),
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
                                $('#'+ret['date_id']).removeClass('res_avail');
                                $('#'+ret['date_id']+' .reservation-desc').css('background-color','#95999c');
                                $('#'+ret['date_id']+' .reservation-title').empty().append('zarezerwowane');
                                $('#reservationModal').modal('hide');
                                infoModal("Twoje zgłoszenie zostało zarejestrowane");
                            }
                            else{
                                infoModal('Przepraszamy wystąpił błąd: <br><br>'+ret['error']+' <br><br> Prosimy przeładować stronę i spróbować ponownie ');
                                $('#reservationModal').modal('hide');
                                $("form")[0].reset();
                            }
                        }
                    }
                });
            }
        }

        //calculate Costs
        function calculateCosts()
        {
            if(formButtonFlag == 2){
                if (allowAjaxSend)
                {
                    let chosenSrvs = $("#carService").val();
                    chosenSrvs = chosenSrvs.toString();
                    chosenSrvs = chosenSrvs.replace(/,/g,'|');

                    $.ajax({
                        url: "/api",
                        type: 'POST',
                        data: 'action=calculateCostsAjax&carService='+chosenSrvs,
                        beforeSend: function(){
                            allowAjaxSend = false;
                        },
                        complete: function(){
                            allowAjaxSend = true;
                        },
                        success: function(msg){
                            if(msg.length)
                            {
                                let ret = JSON.parse(msg);

                                console.log(ret);



                                let modalCalHeader = $("#carMark option:selected").html() + " " + $("#carModel option:selected").html() + " " + $("#carGeneration option:selected").html() + " " + $("#carSerie option:selected").html() + " " + $("#carModification option:selected").html();
                                modalCalHeader = modalCalHeader.replace(/ -/g, " ");
                                modalCalHeader = modalCalHeader.replace(/ null-null/g, " ");

                                let modalCalServiceNames = '';
                                let modalCalServicePrices = '';
                                let calServiceSum = 0;

                                $.each(ret, function(index, value) {
                                    console.log(value);

                                    $.each(value, function(index, value) {
                                        console.log(value);
                                        modalCalServiceNames += '<div class="calModalData">'+`${value['service']}`+'</div>';
                                        modalCalServicePrices += '<div class="calModalData">'+`${value['price']}`+'zł</div>';
                                        calServiceSum += parseFloat(`${value['price']}`);
                                    });
                                });

                                calModal(modalCalHeader, modalCalServiceNames, modalCalServicePrices, calServiceSum);
                            }
                            else{
                                infoModal('Przepraszamy wystąpił błąd: <br><br>'+ret['error']+' <br><br> Prosimy przeładować stronę i spróbować ponownie ');
                            }
                        }
                    });
                }
                formButtonFlag = 0;
            }
        }

        //MODAL
        function calModal(header, names, prices, sum){

            let h = header
            sum = sum+="zł";
            $('#calHeader').empty().append(h);
            $('#calServiceName').empty().append(names);
            $('#calServicePrice').empty().append(prices);
            $('#calServiceSum').empty().append(sum);
            $('#calModal').modal('show');
        }

        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });

        $("#reservationModal").on("hidden.bs.modal", function(){
            $("#reservationModal form")[0].reset();
        });

        function infoModal(text){

            let msg = text;
            $('#infoMsg').empty().append(msg);
            $('#infoModal').modal('show');
        }

        $("#rezerwacje").on('click', '#check_reservations', function () {

            $('#checkModal').modal('show');

        });

        $('#cusPhone').keyup(function(){

            var v = $(this).val().replace(/\D/g, ''); // Remove non-numerics
            v = v.replace(/(\d{3})(?=\d)/g, '$1-'); // Add dashes every 3th digit
            $(this).val(v)
        });



        $("#checkForm").submit(function(event){

            event.preventDefault();

            if($(this).data('adm')==='68GAeNjbLByV2qAg'){

                let phone = $('#custPhone').val();
                $('input[name=phoneToCheck]').val(phone);
                checkReservation();
            }
            else {
               getUserCode();
            }

        });


        $("#checkFormCode").submit(function(event){

            event.preventDefault();
            checkReservation();
        });

        function getUserCode() {

            let request = $.ajax({
                url: "/api",
                method: "POST",
                data: 'action=getUserSMSCodeAjax&'+$('form.checkForm').serialize(),
                dataType: "json"
            });

            request.done(function(data){

                $('#checkModal').modal('hide');

                let ret = JSON.parse(data);
                console.log(ret);

                if(ret['code']===0){
                    let opt="";
                    opt += '<div class="no_reservations">Brak wyników</div>';
                    infoModal(opt);
                }

                if(ret['code']===1){
                    $('input[name=phoneToCheck]').val(ret['phone']);
                    $('#checkModalPhone').modal('show');
                }

            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });


        }

        function checkReservation() {

            let request = $.ajax({
                url: "/api",
                method: "POST",
                data: 'action=checkReservationUserAjax&'+$('form.checkFormCode').serialize(),
                dataType: "json"
            });

            request.done(function(data){

                let opt="";

                if(data.length >0) {

                    opt += ' <div class="table-responsive-sm">\n' +
                        '<table class="table thead-dark">\n' +
                        '  <thead class="thead-dark">\n' +
                        '    <tr>\n' +
                        '      <th scope="col">lp.</th>\n' +
                        '      <th scope="col">data</th>\n' +
                        '      <th scope="col">godzina</th>\n' +
                        '      <th scope="col">nr rej</th>\n' +
                        '      <th scope="col">marka</th>\n' +
                        '      <th scope="col">model</th>\n' +
                        '      <th scope="col">usługa</th>\n' +
                        '    </tr>\n' +
                        '  </thead>\n' +
                        '  <tbody>';

                    for (let i = 0, max = data.length; i < max; i++) {
                        let lp = i + 1;
                        opt += '    <tr>\n' +
                            '      <th scope="row">' + lp + '</th>\n' +
                            '      <td>' + data[i].date + '</td>\n' +
                            '      <td>' + data[i].houre + '</td>\n' +
                            '      <td>' + data[i].carRegNo + '</td>\n' +
                            '      <td>' + data[i].make + '</td>\n' +
                            '      <td>' + data[i].model + '</td>\n' +
                            '      <td>' + data[i].service + '</td>\n' +
                            '    </tr>';
                    }

                    opt += '  </tbody>\n' +
                        '</table>\n' +
                        '</div>';
                }
                else
                {
                    opt += '<div class="no_reservations">Brak wyników</div>';
                }

                // $('#carService').append(opt);
                $('#checkModalPhone').modal('hide');
                infoModal(opt);
            });

            request.fail(function(jqXHR, textStatus){
                alert('Przepraszamy wystąpił błąd: \r \n '+textStatus+' \r \n Prosimy przeładować stronę i spróbować ponownie ');
            });
        }

        function infoModal(text){

            let msg = text;
            $('#checkModal').modal('hide');
            $('#resMsg').empty().append(msg);
            $('#resModal').modal('show');
        }

        $("#resModal").on("hidden.bs.modal", function(){
            $("#resMsg").html("");
        });

        $("#checkModalPhone").on("hidden.bs.modal", function(){
            $("#checkModalPhone form")[0].reset();
        });

        $("#checkModal").on("hidden.bs.modal", function(){
            $("#checkModal form")[0].reset();
        });


        $('#custPhone').keyup(function(){

            var v = $(this).val().replace(/\D/g, ''); // Remove non-numerics
            v = v.replace(/(\d{3})(?=\d)/g, '$1-'); // Add dashes every 3th digit
            $(this).val(v)
        });

    })

}(jQuery);